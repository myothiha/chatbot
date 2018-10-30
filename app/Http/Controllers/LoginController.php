<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function check(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('/');
        }

        return redirect()->back()->withErrors(['Email' => 'Email Not match', 'password' => 'Password Not match']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->intended('/login');
    }
}
