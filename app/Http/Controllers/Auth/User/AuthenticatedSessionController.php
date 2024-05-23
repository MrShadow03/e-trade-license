<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\User;
use Illuminate\View\View;
use App\Services\OtpService;
use Illuminate\Http\Request;
use App\Models\UserOneTimePassword;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\UserLoginRequest;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('user.pages.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(UserLoginRequest $request): RedirectResponse
    {
        try{
            $user = User::where('phone', $request->phone)->first();
            $match = Hash::check($request->password, $user->password);

            if(!$user || !$match){
                throw ValidationException::withMessages([
                    'phone' => trans('auth.failed'),
                ]);
            }

            $otp = UserOneTimePassword::where('user_id', $user->id)->where('type', 'verification')->latest()->first();                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
            $sendTo = config('constants.OTP_METHOD') === 'email' ? $user->email : $user->phone;

            
            if(!$user->isVerified()){
                if(!$otp){
                    // send otp
                    $newOtp = $this->otpService->generateOtp($user);
                    $this->otpService->sendOtp($user, $newOtp);
                    return redirect()->route('user.verify-otp', ['send_to' => $sendTo])->with(
                        [
                            "success"  => "OTP পাঠানো হয়েছে।",
                            "is_sent" => true,
                        ]
                    );
                }else{
                    if($otp->isExpired()){
                        // delete otp and send new otp
                        $this->otpService->deleteOtp($user);
                        $newOtp = $this->otpService->generateOtp($user);
                        $this->otpService->sendOtp($user, $newOtp);
                        return redirect()->route('user.verify-otp', ['send_to' => $sendTo])->with(
                            [
                                "success"  => "OTP পাঠানো হয়েছে।",
                                "is_sent" => true,
                            ]
                        );
                    }else{
                        if(!$otp->hasAttempts()){
                            // delete otp and send to otp page with error message
                            $this->otpService->deleteOtp($user);
                            return redirect()->route('user.verify-otp', ['send_to' => $sendTo])->with([
                                'error' => 'আপনার সকল প্রচেষ্টা শেষ হয়েছে।',
                                'cool_down' => $otp->coolDown(),
                            ]);
                        }else{
                            return redirect()->route('user.verify-otp', ['send_to' => $sendTo])->with('success', 'OTP পাঠানো হয়েছে।');
                        }
                    }
                }
            }else{
                $request->authenticate();
                $request->session()->regenerate();
                return redirect()->intended(route('user.dashboard', absolute: false));
            }
        }catch(ValidationException $e){
            return back()->withErrors($e->errors());
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
