<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;
use App\Models\Buy;

class BuyTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    /**
     *  ID10-1:「購入する」ボタンを押下すると購入が完了する
     */
    public function testBuyItem(){
        //ユーザーを生成
        $yamada = User::create([
            'name' => 'yamada',
            'email' => 'yamada@test.jp',
            'password' => Hash::make('12345678'),
        ]);
        //生成したユーザーでログイン
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response = $this->post('/login', [
            'email' => 'yamada@test.jp',
            'password' => '12345678',
        ]);
        $response->assertRedirect('/');
        $this->assertAuthenticated();
        //購入処理を行う
        $response = $this->get('/purchase/1');
        $response->assertStatus(200);
        $response = $this->post('/purchase/1', [
            'check_delivery' => 'checked',
            'payment_value' => '1',
            'post_code' => '123-4567',
            'address' => '東京都',
            'building' => '〇×マンション',
        ]);
        //購入した商品idの購入明細レコードが存在する事を確認
        $buyCount = Buy::where('item_id', '=', '1')->count();
        $this->assertGreaterThan(0, $buyCount);
    }

    /**
     *  ID10-2:購入した商品は商品一覧画面にて「sold」と表示される
     */
    public function testBuyItemSold(){
        //ユーザーを生成
        $yamada = User::create([
            'name' => 'yamada',
            'email' => 'yamada@test.jp',
            'password' => Hash::make('12345678'),
        ]);
        //生成したユーザーでログイン
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response = $this->post('/login', [
            'email' => 'yamada@test.jp',
            'password' => '12345678',
        ]);
        $response->assertRedirect('/');
        $this->assertAuthenticated();
        //購入処理を行う
        $response = $this->get('/purchase/1');
        $response->assertStatus(200);
        $response = $this->post('/purchase/1', [
            'check_delivery' => 'checked',
            'payment_value' => '1',
            'post_code' => '123-4567',
            'address' => '東京都',
            'building' => '〇×マンション',
        ]);
        //売り切れを確認
        $response = $this->get('/');
        $response->assertSeeText('Sold');
    }

    /**
     *  ID10-3:「プロフィール/購入した商品一覧」に追加されている
     */
    public function testBuyItemSoldProfile(){
        //ユーザーを生成
        $yamada = User::create([
            'name' => 'yamada',
            'email' => 'yamada@test.jp',
            'password' => Hash::make('12345678'),
        ]);
        //生成したユーザーでログイン
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response = $this->post('/login', [
            'email' => 'yamada@test.jp',
            'password' => '12345678',
        ]);
        $response->assertRedirect('/');
        $this->assertAuthenticated();
        //購入処理を行う
        $response = $this->get('/purchase/1');
        $response->assertStatus(200);
        $response = $this->post('/purchase/1', [
            'check_delivery' => 'checked',
            'payment_value' => '1',
            'post_code' => '123-4567',
            'address' => '東京都',
            'building' => '〇×マンション',
        ]);
        //マイページの購入した商品を表示し売り切れを確認
        $response = $this->get('/mypage/?page=buy');
        $response->assertSeeText('Sold');
    }

}


