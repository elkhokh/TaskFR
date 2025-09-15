<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class SocialLoginController extends Controller
{

   public function redirectToProvider($provider)
   {
    // return $provider;
    return Socialite::driver($provider)->redirect();
   }

   public function handlePorviderCallback($provider)
   {
    try { 
        // check if user already exists
        $social_user = Socialite::driver($provider)->user();
            //   dd($social_user);

        $user = User::updateOrCreate([
            'email' => $social_user->getEmail()
        ], [
            'name' => $social_user->getName(),
            // 'email' => $social_user->email,
            'provider_id' => $social_user->id,
            'provider' => $provider,
            'email_verified_at'=>now(),
            'password'=>Hash::make(str::random(8)),
        ]);

        Auth::login($user);
        return redirect()->route('home')->with('success', 'Logged in with ' . ucfirst($provider));
    } catch (\Exception $e) {
        return redirect()->route('login')->with('error', 'wrong with ' . ucfirst($provider) . ' login');
        
    }
}
}