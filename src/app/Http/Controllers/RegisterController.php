<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Buy;
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

    public function mypage(Request $request){
        $user = Auth::user();
        if($request->page=='sell'){
            $items = Item::where('user_id', '=', $user->id)->with('buy')->get();
            return view('mypage.mypage', compact('items', 'request', 'user'));
        }else if($request->page=='buy'){
            $items = $user->boughtItems()->get();
            return view('mypage.mypage', compact('items', 'request', 'user'));
        }
    }

    public function profile(){
        $user = Auth::user();
        return view('mypage.profile', compact('user'));
    }

    public function update( ProfileRequest $request ){
        $user = Auth::user();
        User::find($user->id)->update([
            'img_src' => $request['img_src'],
            'name' => $request['name'],
            'post_code' => $request['post_code'],
            'address' => $request['address'],
            'building' => $request['building']
        ]);
        if(!is_null($request['img_src'])){
            $file = $request->file('img_file');
            $folder = 'user_' . $user->id . "/" . 'icon';
            $extension = $file->getClientOriginalExtension();
            $path = $file->storeAs($folder, 'img_src' . '.' . $extension, 'public');
        }
        return redirect('/');
    }
}