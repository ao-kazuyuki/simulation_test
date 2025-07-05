<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store($item_id){
        $user = Auth::user();
        $exists = Like::where('item_id', $item_id)->where('user_id', $user->id)->exists();
        if( $exists ){
            Like::where('item_id', $item_id)->where('user_id', $user->id)->delete();
            return redirect('/item/' . $item_id)->with('message', 'いいねを取り消しました。');
        }else{
            $like = Like::create([
                'item_id' => $item_id,
                'user_id' => $user->id,
            ]);
            return redirect('/item/' . $item_id)->with('message', '商品にいいねしました。');
        }
    }
}
