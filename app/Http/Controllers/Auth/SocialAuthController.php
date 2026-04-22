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
     * Redirigir a Google
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    /**
     * Manejar callback de Google
     * Restringit a @cendrassos.net
     */
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Restringir a dominio @cendrassos.net
        if (!str_ends_with($googleUser->getEmail(), '@cendrassos.net')) {
            return redirect()->route('login')->withErrors([
                'email' => 'Només es permet accedir amb un correu @cendrassos.net.',
            ]);
        }

        // Buscar usuario existente por google_id o email
        $existingUser = User::where('google_id', $googleUser->getId())->first()
            ?? User::where('email', $googleUser->getEmail())->first();

        if ($existingUser) {
            if (!$existingUser->google_id) {
                $existingUser->update([
                    'google_id' => $googleUser->getId(),
                ]);
            }
            Auth::login($existingUser);
            return redirect()->intended('/schedule');
        }

        // Crear nuevo usuario
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
