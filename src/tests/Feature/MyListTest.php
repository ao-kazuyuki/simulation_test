<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;
use App\Models\Like;
use App\Models\Buy;
use App\Models\Item;
use App\Models\CategoryItem;

class MyListTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    /**
     *  ID5-1:いいねした商品だけが表示される
     */
    public function testGetMyLikedItem(){
        //ユーザーを生成
        $user = User::create([
            'name' => 'yamada',
            'email' => 'test@test.jp',
            'password' => Hash::make('12345678'),
        ]);
        //生成したユーザーでitem_idが1の商品(腕時計)にいいね処理
        $like = Like::create([
            'item_id' => '1',
            'user_id' => $user->id
        ]);
        //生成したユーザーでログイン
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response = $this->post('/login', [
            'email' => 'test@test.jp',
            'password' => '12345678',
        ]);
        $response->assertRedirect('/');
        $this->assertAuthenticated();
        //マイリストを開き腕時計があるか調べる
        $response = $this->get('/?page=mylist');
        $response->assertStatus(200);
        $this->get('/?page=mylist')->assertSee('腕時計');
    }

    /**
     *  ID5-2:購入済み商品は「Sold」と表示される
     */
    public function testGetMyLikedBuyItem(){
        //ユーザーを生成
        $user = User::create([
            'name' => 'yamada',
            'email' => 'test@test.jp',
            'password' => Hash::make('12345678'),
        ]);
        //生成したユーザーでitem_idが1の商品(腕時計)にいいね処理
        $like = Like::create([
            'item_id' => '1',
            'user_id' => $user->id
        ]);
        //その商品の購入処理
        $buy = Buy::create([
            'item_id' => $like->item_id,
            'user_id' => $user->id,
            'payment_id' => '1',
            'post_code' => '123-4567',
            'address' => '東京都',
            'building' => '〇×マンション123',
        ]);
        //生成したユーザーでログイン
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response = $this->post('/login', [
            'email' => 'test@test.jp',
            'password' => '12345678',
        ]);
        $response->assertRedirect('/');
        $this->assertAuthenticated();
        //マイリストを開き腕時計があるか調べ、更にSold表示があるか調べる。
        $response = $this->get('/?page=mylist');
        $response->assertStatus(200);
        $this->get('/?page=mylist')
            ->assertSee('腕時計')
            ->assertSee('Sold');
    }

    /**
     *  ID5-3:自分が出品した商品は表示されない
     */
    public function testHiddenMySelfItem(){
        //ユーザーを生成
        $user = User::create([
            'name' => 'yamada',
            'email' => 'test@test.jp',
            'password' => Hash::make('12345678'),
        ]);
        //生成したユーザーIDを使って商品を出品
        $item = Item::create([
            'img_src' => 'img_src.jpg',
            'user_id' => $user->id,
            'condition_id' => '1',
            'name' => 'マイアイテム',
            'explanation' => '自分自身が出品した商品',
            'price' => '100',
        ]);
        $categoryItem = CategoryItem::create([
            'category_id' => '1',
            'item_id' => $item->id,
        ]);
        //生成したユーザーでログイン
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response = $this->post('/login', [
            'email' => 'test@test.jp',
            'password' => '12345678',
        ]);
        $response->assertRedirect('/');
        $this->assertAuthenticated();
        //マイリストを開き自分が出品した商品名が存在しない事を確認
        $response = $this->get('/?page=mylist');
        $response->assertStatus(200);
        $this->get('/?page=mylist')->assertDontSee('マイアイテム');
    }

    /**
     *  ID5-4:未認証の場合は何も表示されない
     */
    public function testUncertifiedLikedItem(){
        //未認証ユーザーかチェックしマイリストを取得
        $this->assertGuest();
        $response = $this->get('/?page=mylist');
        $response->assertStatus(200);
        //ビューに渡された商品の配列が空かチェックする
        $response->assertViewHas('items');
        $viewData = $response->viewData('items');
        $this->assertIsArray($viewData);
        $this->assertCount(0, $viewData);
    }
}
