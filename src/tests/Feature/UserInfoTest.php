<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Buy;

class UserInfoTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    /**
     *  ID13-1:必要な情報が取得できる（プロフィール画像、ユーザー名、出品した商品一覧、購入した商品一覧）
     */
    public function testShowUserInfo(){
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
        $response->assertRedirect('/');
        $this->assertAuthenticated();
        //生成したユーザーIDを使って商品を出品
        $item = Item::create([
            'img_src' => 'img_src.jpg',
            'user_id' => $user->id,
            'condition_id' => '1',
            'name' => 'マイアイテム',
            'explanation' => '自分自身が出品した商品',
            'price' => '100',
        ]);
        //出品した商品(マイアイテム)が表示されていることを確認
        $response = $this->get('/mypage?page=sell');
        $response->assertSeeText($user->name)->assertSeeText('マイアイテム');
        //商品の購入処理
        $buy = Buy::create([
            'item_id' => '1',
            'user_id' => $user->id,
            'payment_id' => '1',
            'post_code' => '123-4567',
            'address' => '東京都',
            'building' => '〇×マンション123',
        ]);
        //購入した商品(腕時計)が表示されており、売り切れ表示があることを確認
        $response = $this->get('/mypage?page=buy');
        $response->assertSeeText($user->name)->assertSeeText('腕時計')->assertSeeText('Sold');
    }

}
