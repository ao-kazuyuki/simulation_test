<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(){
        return view('auth.register');
    }

    public function store( RegisterRequest $request ){
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        Auth::login($user);
        return redirect('/mypage/profile');
    }

    public function profile(){
        $user = Auth::user();
        return view('mypage.profile', compact('user'));
    }

    public function update( ProfileRequest $request ){
        User::find($request->id)->update([
            'img_src' => $request['img_src'],
            'name' => $request['name'],
            'post_code' => $request['post_code'],
            'address' => $request['address'],
            'building' => $request['building']
        ]);
        return redirect('/');
    }
}