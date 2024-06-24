<?php

namespace App\Http\Controllers\User;

use App\Helpers\Helpers;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View {
        return view('user.pages.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(UserProfileUpdateRequest $request): RedirectResponse {
        $request->user()->email = $request->email;

        if($request->hasFile('image')) {
            $imgPath = Helpers::resizeImage();
            $request->user()->addMedia($imgPath)->toMediaCollection('dp');
        }

        if ($request->user()->isDirty('phone')) {
            $request->user()->phone_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('user.profile.edit')->with('success', 'প্রোফাইলের তথ্য সফলভাবে আপডেট হয়েছে।');
    }

    public function passwordUpdate(Request $request): RedirectResponse {
        $user = auth()->user();
        $isCurrentPasswordRequired = $user->hasPurePassword() ? 'required | current_password' : 'nullable';

        $validation = Validator::make($request->all(), [
            'current_password' => $isCurrentPasswordRequired,
            'password' => 'required|min:8|confirmed',
        ], [
            'current_password.current_password' => 'বর্তমান পাসওয়ার্ড সঠিক নয়।',
            'password.min' => 'পাসওয়ার্ড অবশ্যই ৮ অক্ষরের বড় হতে হবে।',
            'password.confirmed' => 'নিশ্চিতকরণ পাসওয়ার্ড সঠিক নয়।',
        ]);
        
        if ($validation->fails()) {
            return redirect()->route('user.profile.edit')->with('error', $validation->errors()->first());
        }

        if($user->hasPurePassword() && !(Hash::check($request->current_password, $user->password))) {
            return redirect()->route('user.profile.edit')->with('error', 'বর্তমান পাসওয়ার্ড সঠিক নয়।');
        }

        auth()->user()->update([
            'password' => bcrypt($request->password),
            'needs_password_reset' => false,
        ]);

        return redirect()->route('user.profile.edit')->with('info', 'পাসওয়ার্ড পরিবর্তন সফল হয়েছে।');
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
