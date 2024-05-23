<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\UserOneTimePassword;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use App\Services\OtpService;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('user.pages.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'min:11', 'max:11', 'exists:users,phone'],
        ]);

        // get the user by phone number
        $user = User::where('phone', $request->phone)->first();

        // if the user is not found then show the error message
        if(!$user){
            return redirect()->back()->with('error', 'এই ফোন নম্বরে কোন অ্যাকাউন্ট পাওয়া যায়নি।');
        }

        $otp = UserOneTimePassword::where('user_id', $user?->id)->latest()->first();
        $sendTo = config('constants.OTP_METHOD') === 'email' ? $user?->email : $user?->phone;

        $otpService = new OtpService();

        // if the user is not verified sent the user to the verification page 
        if(!$user->isVerified()){
            if(!$otp){
                // send otp
                $newOtp = $otpService->generateOtp($user);
                $otpService->sendOtp($user, $newOtp);
                return redirect()->route('user.verify-otp', ['send_to' => $sendTo])->with(
                    [
                        "success"  => "OTP পাঠানো হয়েছে।",
                        "is_sent" => true,
                    ]
                );
            }else{
                if($otp->isExpired()){
                    // delete otp and send new otp
                    $otpService->deleteOtp($user);
                    $newOtp = $otpService->generateOtp($user);
                    $otpService->sendOtp($user, $newOtp);
                    return redirect()->route('user.verify-otp', ['send_to' => $sendTo])->with(
                        [
                            "success"  => "OTP পাঠানো হয়েছে।",
                            "is_sent" => true,
                        ]
                    );
                }else{
                    if(!$otp->hasAttempts()){
                        // delete otp and send to otp page with error message
                        $otpService->deleteOtp($user);
                        return redirect()->route('user.verify-otp', ['send_to' => $sendTo])->with([
                            'error' => 'আপনার সকল প্রচেষ্টা শেষ হয়েছে।',
                            'cool_down' => $otp->coolDown(),
                        ]);
                    }else{
                        return redirect()->route('user.verify-otp', ['send_to' => $sendTo])->with('success', 'OTP পাঠানো হয়েছে।');
                    }
                }
            }
        }

        $otp = UserOneTimePassword::where('user_id', $user->id)->where('type', 'password_reset')->latest()->first();
        if(!$otp){
            // send otp
            $newOtp = $otpService->generateOtp($user, 'password_reset');
            $otpService->sendOtp($user, $newOtp);
            return redirect()->route('user.verify-otp', ['send_to' => $sendTo])->with(
                [
                    "success"  => "পাসওয়ার্ড রিসেট OTP পাঠানো হয়েছে।",
                    "is_sent" => true,
                ]
            );
        }else{
            if($otp->isExpired()){
                // delete otp and send new otp
                $otpService->deleteOtp($user);
                $newOtp = $otpService->generateOtp($user, 'password_reset');
                $otpService->sendOtp($user, $newOtp);
                return redirect()->route('user.verify-otp', ['send_to' => $sendTo])->with(
                    [
                        "success"  => "পাসওয়ার্ড রিসেট OTP পাঠানো হয়েছে।",
                        "is_sent" => true,
                    ]
                );
            }else{
                if(!$otp->hasAttempts()){
                    // delete otp and send to otp page with error message
                    $otpService->deleteOtp($user);
                    return redirect()->route('user.verify-otp', ['send_to' => $sendTo])->with([
                        'error' => 'আপনার সকল প্রচেষ্টা শেষ হয়েছে।',
                        'cool_down' => $otp->coolDown(),
                    ]);
                }else{
                    return redirect()->route('user.verify-otp', ['send_to' => $sendTo])->with('success', 'OTP পাঠানো হয়েছে।');
                }
            }
        }
    }
}
