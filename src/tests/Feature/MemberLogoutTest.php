<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class MemberLogoutTest extends TestCase
{

    use RefreshDatabase;

    /**
     *  ID3-1:ログアウトができる
     */
    public function testLogout(){
        //ユーザーを生成してログイン
        $user = User::create([
            'name' => 'yamada',
            'email' => 'test@test.jp',
            'password' => Hash::make('12345678'),
        ]);
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response = $this->post('/login', [
            'email' => 'test@test.jp',
            'password' => '12345678',
        ]);
        $response->assertRedirect('/');
        $this->assertAuthenticated();
        //ログアウトを確認
        $response = $this->post('/logout');
        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
