<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class UserInfoEditTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    /**
     *  ID14-1:変更項目が初期値として過去設定されていること（プロフィール画像、ユーザー名、郵便番号、住所）
     */
    public function testChangeUserAddress(){
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
        //プロフィール設定画面で住所情報を設定する
        $postCode = '123-4567';
        $address = '東京都';
        $building = '〇×マンション';
        $response = $this->get('/mypage/profile');
        $response = $this->patch('/mypage/profile/update', [
            'post_code' => $postCode,
            'address' => $address,
            'building' => $building,
        ]);
        //過去に行った住所の変更内容が表示されているかを確認
        $response = $this->get('/mypage/profile');
        $response->assertSee($postCode)->assertSee($address)->assertSee($building);
    }

}
