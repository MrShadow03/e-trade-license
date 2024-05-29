<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserOtpRequest;

class UserOneTimePasswordController extends Controller
{
    public function create(Request $request)
    {
        $destination = $request->has('send_to') ? $request->send_to : null;

        if (!$destination) {
            return redirect()->route('user.login');
        }

        if(config('constants.OTP_METHOD') === 'email') {
            $user = User::Where('email', $destination)->first();
        }else{
            $user = User::Where('phone', $destination)->first();
        }
    
        if (!$user || !$user->otp) {
            return redirect()->route('user.login');
        }

        return view('user.pages.verify-otp', [
            'send_to' => $destination,
            'method' => config('constants.OTP_METHOD')
        ]);
    }

    public function verify(UserOtpRequest $request){
        $otp = $request->otp;
        $send_to = $request->send_to;

        if(config('constants.OTP_METHOD') === 'email') {
            $user = User::Where('email', $send_to)->first();
        }else{
            $user = User::Where('phone', $send_to)->first();
        }

        if (!$user || !$user->otp) {
            return redirect()->route('user.login');
        }

        $otpService = new OtpService();
        $userOtp = $user->otp;
        
        if ($userOtp && $userOtp->otp !== $otp) {
            $userOtp->decrement('left_attempts');
            if (!$userOtp->hasAttempts()){
                $coolDown = $userOtp->coolDown();
                $userOtp->delete();
                return redirect()->route('user.verify-otp', ['send_to' => $send_to])->with([
                    'error' => 'আপনার সব প্রচেষ্টা ব্যর্থ হয়েছে। পুনরায় চেষ্টা করতে অপেক্ষা করুন।',
                    'can_resend' => true,
                    'cool_down' => $coolDown,
                ]);
            }
            return redirect()->route('user.verify-otp', ['send_to' => $send_to])->with([
                'error' => 'আপনার প্রদত্ত ওটিপি সঠিক নয়।',
                'attempts' => $userOtp->left_attempts,
                'can_resend' => false,
            ]);
        }elseif(!$userOtp){
            return redirect()->route('user.login');
        }

        
        $otpType = $userOtp->type;
        $otpService->deleteOtp($user);
        Auth::login($user);
        $request->session()->regenerate();

        if($otpType === 'password_reset'){
            $user->needs_password_reset = true;
            $user->save();
            return redirect()->route('user.profile.edit');
        }else{
            $user->markUserPhoneAsVerified();
            return redirect()->route('user.dashboard');
        }
    }
}
