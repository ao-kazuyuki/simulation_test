<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;
use App\Models\Like;

class LikeTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    /**
     *  ID8-1:いいねアイコンを押下することによって、いいねした商品として登録することができる。
     */
    public function testLikeCount(){
        //ユーザーを生成
        $user = User::create([
            'name' => 'yamada',
            'email' => 'test@test.jp',
            'password' => Hash::make('12345678'),
        ]);
        //生成したユーザーでログイン
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response = $this->post('/login', [
            'email' => 'test@test.jp',
            'password' => '12345678',
        ]);
        //商品ページにアクセスしていいねをする
        $response = $this->get('/item/1');
        $response->assertStatus(200);
        $response = $this->post('/item/1/like');
        //いいねした商品のいいねレコードが1件あるか調べる
        $likeCount = Like::where('item_id', '=', '1')->count();
        $this->assertEquals($likeCount, 1);
    }

    /**
     *  ID8-2:追加済みのアイコンは色が変化する
     */
    public function testLikeButtonChanged(){
        //ユーザーを生成
        $user = User::create([
            'name' => 'yamada',
            'email' => 'test@test.jp',
            'password' => Hash::make('12345678'),
        ]);
        //生成したユーザーでログイン
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response = $this->post('/login', [
            'email' => 'test@test.jp',
            'password' => '12345678',
        ]);
        //商品ページにアクセスしていいねをする
        $response = $this->get('/item/1');
        $response->assertStatus(200);
        $response = $this->post('/item/1/like');
        //色付きのいいねボタンの画像のファイル名がページにあるか調べる
        $response = $this->get('/item/1');
        $response->assertStatus(200)->assertSee('star-check.png');
    }

    /**
     *  ID8-3:再度いいねアイコンを押下することによって、いいねを解除することができる。
     */
    public function testLikeCancellation(){
        //ユーザーを生成
        $user = User::create([
            'name' => 'yamada',
            'email' => 'test@test.jp',
            'password' => Hash::make('12345678'),
        ]);
        //生成したユーザーでログイン
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response = $this->post('/login', [
            'email' => 'test@test.jp',
            'password' => '12345678',
        ]);
        //商品ページにアクセスしていいねをする
        $response = $this->get('/item/1');
        $response->assertStatus(200);
        $response = $this->post('/item/1/like');
        //いいね直後のいいね数を記憶
        $likeCount = Like::where('item_id', '=', '1')->count();
        //再度商品詳細ページにていいねボタンを押下
        $response = $this->get('/item/1');
        $response->assertStatus(200);
        $response = $this->post('/item/1/like');
        //いいね直後の値と比較して減少していることを確認
        $likeCountCancel = Like::where('item_id', '=', '1')->count();
        $this->assertLessThan($likeCount, $likeCountCancel);
    }

}
