<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to Google's OAuth consent screen.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    /**
     * Handle the callback from Google after authentication.
     * Only allows users with a @cendrassos.net email address.
     */
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Restrict access to @cendrassos.net domain only
        if (!str_ends_with($googleUser->getEmail(), '@cendrassos.net')) {
            return redirect()->route('login')->withErrors([
                'email' => 'Només es permet accedir amb un correu @cendrassos.net',
            ]);
        }

        // Check if user already exists by google_id or email
        $existingUser = User::where('google_id', $googleUser->getId())->first()
            ?? User::where('email', $googleUser->getEmail())->first();

        if ($existingUser) {
            // Link google_id if the user registered manually before
            if (!$existingUser->google_id) {
                $existingUser->update([
                    'google_id' => $googleUser->getId(),
                ]);
            }
            Auth::login($existingUser);
            return redirect()->intended('/schedule');
        }

        // Create a new user with a random password (login is via Google)
        $user = User::create([
            'name'      => $googleUser->getName(),
            'email'     => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'password'  => bcrypt(Str::random(24)),
            'role'      => 'student',
        ]);

        Auth::login($user);
        return redirect()->intended('/schedule');
    }
}
