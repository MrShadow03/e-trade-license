<?php

namespace App\Services;

use App\Models\User;
use App\Mail\OtpMail;
use App\Traits\MessageHandling;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    use MessageHandling;
    public function generateOtp(User $user, $type = 'password_reset')
    {
        $otp = $this->OTPGenerator();
        $user->otp()->create([
            'otp' => $otp,
            'type' => $type,
            'expires_at' => now()->addMinutes(config('constants.EXPIRES_IN')),
            'left_attempts' => config('constants.MAX_ATTEMPTS'),
            'last_used_ip' => request()->ip(),
        ]);

        return $otp;
    }

    public function generateOtpUrl(User $user, $type = 'password_reset')
    {
        $otp = $this->OTPGenerator();

        $user->otp()->create([
            'otp' => $otp,
            'type' => $type,
            'expires_at' => now()->addMinutes(config('constants.EXPIRES_IN')),
            'left_attempts' => config('constants.MAX_ATTEMPTS'),
            'last_used_ip' => request()->ip(),
        ]);

        return route('user.password.reset', $otp);
    }

    public function sendOtp(User $user, $otp)
    {
        if (config('constants.OTP_METHOD') === 'email') {
            Mail::to($user->email)->send(new OtpMail($otp, $user->name));
        } else {
            $message = explode(' ', $user->name)[0].",your BCC OTP is: $otp";
            $this->sendSMS($user->phone, $message);
        }

        return true;
    }

    public function deleteOtp(User $user)
    {
        $user->otp()->delete();
    }

    public function OTPGenerator() {
        $otp = '';
        $letters = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
    
        $useLetters = true; // Start with a letter

        // Generate 3 letters and numbers alternately
        for ($i = 0; $i < 6; $i++) {
            if ($useLetters) {
                $otp .= $letters[mt_rand(0, strlen($letters) - 1)];
                $useLetters = false;
            } else {
                $otp .= $numbers[mt_rand(0, strlen($numbers) - 1)];
                $useLetters = true;
            }
        }
    
        return $otp;
    }
}