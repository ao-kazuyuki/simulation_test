<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class MemberLoginTest extends TestCase
{

    use RefreshDatabase;

    /**
     *  ID2-1:メールアドレスが入力されていない場合、バリデーションメッセージが表示される
     */
    public function testLoginMailHasErrors(){
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response = $this->post('/login', [
            'email' => '',
            'password' => '12345678',
        ]);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['email' => 'メールアドレスを入力してください']);
    }

    /**
     *  ID2-2:パスワードが入力されていない場合、バリデーションメッセージが表示される
     */
    public function testLoginPasswordHasErrors(){
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response = $this->post('/login', [
            'email' => 'test@test.jp',
            'password' => '',
        ]);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['password' => 'パスワードを入力してください']);
    }

    /**
     *  ID2-3:入力情報が間違っている場合、バリデーションメッセージが表示される
     */
    public function testLoginErrors(){
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response = $this->post('/login', [
            'email' => 'user@test.jp',
            'password' => '12345678',
        ]);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['email' => 'ログイン情報が登録されていません']);
    }

    /**
     *  ID2-4:正しい情報が入力された場合、ログイン処理が実行される
     */
    public function testSuccessLogin(){
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
    }
}
