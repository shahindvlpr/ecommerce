<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    // Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $socialUser = Socialite::driver('google')->user();
            return $this->handleSocialLogin($socialUser, 'google');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google login failed!');
        }
    }

    // Facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $socialUser = Socialite::driver('facebook')->user();
            return $this->handleSocialLogin($socialUser, 'facebook');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Facebook login failed!');
        }
    }

    // GitHub (Optional)
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGithubCallback()
    {
        try {
            $socialUser = Socialite::driver('github')->user();
            return $this->handleSocialLogin($socialUser, 'github');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'GitHub login failed!');
        }
    }

    private function handleSocialLogin($socialUser, $provider)
    {
        $user = User::where('email', $socialUser->email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $socialUser->name ?? $socialUser->nickname ?? 'User',
                'email' => $socialUser->email,
                'password' => bcrypt(Str::random(16)),
                'role' => 'customer',
                'email_verified_at' => now(),
                'provider' => $provider,
                'provider_id' => $socialUser->id,
            ]);
        }

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Welcome back!');
    }
}