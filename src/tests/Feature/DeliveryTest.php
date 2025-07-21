<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;
use App\Models\Buy;

class DeliveryTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    /**
     *  ID12-1:送付先住所変更画面にて登録した住所が商品購入画面に反映されている
     */
    public function testDeliveryAddressChange(){
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
        //送付先住所変更画面を表示して送付先を入力
        $postCode = '123-4567';
        $address = '東京都';
        $building = '〇×マンション';
        $response = $this->get('/purchase/address/1');
        $response->assertStatus(200);
        $response = $this->patch('/purchase/1', [
            'post_code' => $postCode,
            'address' => $address,
            'building' => $building,
        ]);
        //変更内容がページに表示されているか確認
        $response->assertSee($postCode)->assertSee($address)->assertSee($building);
    }

    /**
     *  ID12-2:購入した商品に送付先住所が紐づいて登録される
     */
    public function testDeliveryAddressStore(){
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
        //送付先住所変更画面を表示して送付先を入力
        $postCode = '123-4567';
        $address = '東京都';
        $building = '〇×マンション';
        $response = $this->get('/purchase/address/1');
        $response->assertStatus(200);
        $response = $this->post('/purchase/1', [
            'check_delivery' => 'checked',
            'payment_value' => '1',
            'post_code' => $postCode,
            'address' => $address,
            'building' => $building,
        ]);
        //設定した住所がレコードのカラムに存在するかチェック
        $buy = Buy::where('item_id', '=', '1')->where('user_id', '=', $user->id)->get();
        $this->assertEquals($postCode, $buy->toArray()[0]['post_code']);
        $this->assertEquals($address, $buy->toArray()[0]['address']);
        $this->assertEquals($building, $buy->toArray()[0]['building']);
    }

}
