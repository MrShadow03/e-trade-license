<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\User;
use App\Mail\OtpMail;
use App\Mail\OTPEmail;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Traits\MessageHandling;
use Illuminate\Validation\Rules;
use App\Models\UserOneTimePassword;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\UserRegisterRequest;
use App\Services\OtpService;

class RegisteredUserController extends Controller
{
    use MessageHandling;
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('user.pages.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserRegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        $otpService = new OtpService();
        $otp = $otpService->generateOtp($user);
        $otpService->sendOtp($user, $otp);

        $sentTo = config('constants.OTP_METHOD') === 'email' ? $user->email : $user->phone;

        return redirect()->route('user.verify-otp', ['send_to' => $sentTo])->with([
            'success' => 'OTP পাঠানো হয়েছে।',
            'is_sent' => true,
        ]);
    }
}
