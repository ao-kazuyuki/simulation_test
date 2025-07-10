<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use App\Models\Comment;
use App\Models\CategoryItem;
use App\Models\Like;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index(Request $request){
        if(Auth::check()){
            $user = Auth::user();
            if($request->page=='mylist'){
                $items = $user->likedItems()->with('buy')->orderBy('id', 'asc')->get();
                return view('index', compact('items', 'request'));
            }else{
                $items = Item::where('user_id', '!=', $user->id)->with('buy')->get();
                return view('index', compact('items'));
            }
        }else{
            if($request->page=='mylist'){
                $items = [];
                return view('index', compact('items', 'request'));
            }else{
                $items = Item::with('buy')->get();
                return view('index', compact('items'));
            }
        }
    }

    public function sell(){
        $user = Auth::user();
        $categories = Category::all();
        $conditions = Condition::all();
        return view('sell', compact('user', 'categories', 'conditions'));
    }

    public function store( ExhibitionRequest $request ){
        DB::beginTransaction();
        try{
            $item = Item::create([
                'img_src' => $request['img_src'],
                'user_id' => $request['id'],
                'condition_id' => $request['condition'],
                'name' => $request['name'],
                'brand' => $request['brand'],
                'explanation' => $request['explanation'],
                'price' => $request['price'],
            ]);
            if(!empty($request['category_group'])){
                foreach($request['category_group'] as $category){
                    CategoryItem::create([
                        'category_id' => $category,
                        'item_id' => $item->id
                    ]);
                }
            }
            DB::commit();
            if(!is_null($item->img_src)){
                $file = $request->file('img_file');
                $folder = 'user_' . $item->user_id . "/" . 'item_' . $item->id;
                $extension = $file->getClientOriginalExtension();
                $path = $file->storeAs($folder, 'img_src' . '.' . $extension, 'public');
            }
            return redirect('/')->with('message', '出品が完了しました。');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect('/')->with('message', '出品に失敗しました。操作をやり直してください。');
        }
    }

    public function showItem($item_id){
        $item = Item::with(['categories', 'condition'])->find($item_id);
        $likeCount = Like::where('item_id', $item_id)->count();      
        $comments = Comment::with(['user'])->where('item_id', $item_id)->orderBy('created_at', 'desc')->get();
        $user = Auth::user();
        if(Auth::check()){
            $exists = Like::where('item_id', $item_id)->where('user_id', $user->id)->exists();
            if( $exists ){
                $imgPath = 'img/star-check.png';
            }else{
                $imgPath = 'img/star.png';
            }
            return view('detail', compact('item', 'comments', 'likeCount', 'imgPath'));
        }else{
            return view('detail', compact('item', 'comments', 'likeCount',));
        }
    }

}