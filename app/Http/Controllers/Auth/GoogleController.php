<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            
            $finduser = User::where('google_id', $user->id)->first();
            
            if($finduser){
                Auth::login($finduser);
                
                // Redirect berdasarkan role
                if ($finduser->isAdmin()) {
                    return redirect()->intended(route('admin.dashboard'));
                }
                return redirect()->intended(route('user.dashboard'));
                
            } else {
                // Generate username dari email
                $username = explode('@', $user->email)[0];
                $count = 1;
                $tempUsername = $username;
                while(User::where('username', $tempUsername)->exists()) {
                    $tempUsername = $username . $count;
                    $count++;
                }
                
                $newUser = User::create([
                    'fullname' => $user->name,
                    'username' => $tempUsername,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'avatar' => $user->avatar,
                    'password' => encrypt('123456dummy'),
                    'role' => 'user'
                ]);
    
                Auth::login($newUser);
                return redirect()->intended(route('user.dashboard'));
            }
    
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Sepertinya telah terjadi kesalahan di Google. Silahkan coba lagi.');
        }
    }
}
