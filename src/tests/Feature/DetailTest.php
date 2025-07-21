<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\CategoryItem;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Condition;
use App\Models\Category;

class DetailTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    /**
     *  ID7-1:必要な情報が表示される（商品画像、商品名、ブランド名、価格、いいね数、コメント数、商品説明、商品情報（カテゴリ、商品の状態）、コメント数、コメントしたユーザー情報、コメント内容）
     */
    public function testShowItemDetail(){
        //ユーザーを生成
        $yamada = User::create([
            'name' => 'yamada',
            'email' => 'yamada@test.jp',
            'password' => Hash::make('12345678'),
        ]);
        //生成したユーザーIDを使って商品を出品
        $item = Item::create([
            'img_src' => 'img_src.jpg',
            'user_id' => $yamada->id,
            'condition_id' => '1',
            'name' => 'マイアイテム',
            'brand' => 'マイブランド',
            'explanation' => '自分自身が出品した商品',
            'price' => '100',
        ]);
        //商品カテゴリを設定
        CategoryItem::create([
            'category_id' => '1',
            'item_id' => $item->id,
        ]);
        //いいねとコメントを行うユーザーを生成
        $itou = User::create([
            'name' => 'itou',
            'email' => 'itou@test.jp',
            'password' => Hash::make('12345678'),
        ]);
        //生成したユーザーで生成した商品にいいねとコメント処理
        $like = Like::create([
            'item_id' => $item->id,
            'user_id' => $itou->id
        ]);
        $comment = Comment::create([
            'item_id' => $item->id,
            'user_id' => $itou->id,
            'content' => 'サンプルコメント',
        ]);
        //生成した商品ページに遷移して各商品情報が存在するか
        $response = $this->get('/item/' . $item->id);
        $response->assertStatus(200);
        $likeCounts = $response->viewData('likeCount');
        $comments = $response->viewData('comments');
        $categories = Item::with(['categories'])->find($item->id);
        $conditions = Condition::all();
        $response->assertStatus(200)
            ->assertSee($item->name)
            ->assertSee($item->brand)
            ->assertSee($item->price)
            ->assertSee($likeCounts)
            ->assertSee($comments->count())
            ->assertSee($item->explanation)
            ->assertSee($categories->toArray()['categories'][0]['content'])
            ->assertSee($conditions[ $item->condition_id - 1 ]->toArray()['content'])
            ->assertSee($comments->toArray()[0]['user']['name'])
            ->assertSee($comments->toArray()[0]['content']);
    }

    /**
     *  ID7-2:複数選択されたカテゴリが表示されているか
     */
    public function testShowItemLikes(){
        //ユーザーを生成
        $yamada = User::create([
            'name' => 'yamada',
            'email' => 'yamada@test.jp',
            'password' => Hash::make('12345678'),
        ]);
        //生成したユーザーIDを使って複数カテゴリの商品を出品
        $item = Item::create([
            'img_src' => 'img_src.jpg',
            'user_id' => $yamada->id,
            'condition_id' => '1',
            'name' => 'マイアイテム',
            'brand' => 'マイブランド',
            'explanation' => '自分自身が出品した商品',
            'price' => '100',
        ]);
        //複数のカテゴリを設定
        $categoryNumList = [1, 2, 3];
        foreach($categoryNumList as $categoryNum){
            CategoryItem::create([
                'category_id' => $categoryNum,
                'item_id' => $item->id,
            ]);
        }
        //生成した商品ページに遷移して複数設定したカテゴリが存在するか
        $response = $this->get('/item/' . $item->id);
        $response->assertStatus(200);
        $categories = Category::all();
        foreach($categoryNumList as $categoryNum){
            $response->assertStatus(200)->assertSee($categories->toArray()[$categoryNum - 1]['content']);
        }
    }
}
