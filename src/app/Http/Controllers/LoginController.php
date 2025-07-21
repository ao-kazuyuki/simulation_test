<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLogin(){
        return view('auth.login');
    }

    public function login( LoginRequest $request ){
        $user = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];
        if(Auth::attempt($user, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        throw ValidationException::withMessages([
            'email' => __('ログイン情報が登録されていません'),
        ]);
    }

    public function logout( Request $request ){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
