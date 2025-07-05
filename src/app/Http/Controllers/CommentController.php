<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentRequest $request, $item_id){
        $user = Auth::user();
        $comment = Comment::create([
            'item_id' => $item_id,
            'user_id' => $user->id,
            'content' => $request->content,
        ]);
        return redirect('/item/' . $item_id)->with('message', 'コメントが投稿されました。');
    }
}
