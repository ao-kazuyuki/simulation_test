<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class MemberRegistrationTest extends TestCase
{

    use RefreshDatabase;

    /**
     *  ID1-1:名前が入力されていない場合、バリデーションメッセージが表示される
     */
    public function testRegisterNameHasErrors(){
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@test.jp',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);
        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['name' => 'お名前を入力してください']);
    }

    /**
     *  ID1-2:メールアドレスが入力されていない場合、バリデーションメッセージが表示される
     */
    public function testRegisterMailHasErrors(){
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response = $this->post('/register', [
            'name' => 'yamada',
            'email' => '',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);
        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['email' => 'メールアドレスを入力してください']);
    }

    /**
     *  ID1-3:パスワードが入力されていない場合、バリデーションメッセージが表示される
     */
    public function testRegisterPasswordHasErrors(){
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response = $this->post('/register', [
            'name' => 'yamada',
            'email' => 'test@test.jp',
            'password' => '',
            'password_confirmation' => '12345678'
        ]);
        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['password' => 'パスワードを入力してください']);
    }

    /**
     *  ID1-4:パスワードが7文字以下の場合、バリデーションメッセージが表示される
     */
    public function testRegisterPasswordLength(){
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response = $this->post('/register', [
            'name' => 'yamada',
            'email' => 'test@test.jp',
            'password' => '1234567',
            'password_confirmation' => '1234567'
        ]);
        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['password' => 'パスワードは8文字以上で入力してください']);
    }

    /**
     *  ID1-5:パスワードが確認用パスワードと一致しない場合、バリデーションメッセージが表示される
     */
    public function testRegisterPasswordUnMatch(){
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response = $this->post('/register', [
            'name' => 'yamada',
            'email' => 'test@test.jp',
            'password' => '12345678',
            'password_confirmation' => '123456789'
        ]);
        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['password_confirmation' => 'パスワードと一致しません']);
    }

    /**
     *  ID1-6:全ての項目が入力されている場合、会員情報が登録され、プロフィール設定画面に遷移される
     */
    public function testRegisterStoreMemberData(){
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response = $this->post('/register', [
            'name' => 'yamada',
            'email' => 'test@test.jp',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);
        $this->assertDatabaseHas('users',[
            'name' => 'yamada',
            'email' => 'test@test.jp',
        ]);
        $response->assertRedirect('/mypage/profile');
    }
}
