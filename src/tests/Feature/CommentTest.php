<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;
use App\Models\Comment;

class CommentTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    /**
     *  ID9-1:ログイン済みのユーザーはコメントを送信できる
     */
    public function testComment(){
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
        //商品ページにアクセスしてコメントをする
        $response = $this->get('/item/1');
        $response->assertStatus(200);
        $commentContent = 'テストコメントです';
        $response = $this->post('/item/1/comment', [
            'content' => $commentContent,
        ]);
        $userComment = Comment::where('item_id', '=', '1')
                                ->where('user_id', '=', $yamada->id)->get();
        //データベースに登録されたコメントと一致するか確認
        $this->assertEquals($commentContent, $userComment[0]['content']);
    }

    /**
     *  ID9-2:ログイン前のユーザーはコメントを送信できない
     */
    public function testUncertifiedLikedItem(){
        //未認証ユーザーか商品詳細ページにアクセスしコメントを送信
        $this->assertGuest();
        $response = $this->get('/item/1');
        $response->assertStatus(200);
        $response = $this->post('/item/1/comment', [
            'content' => 'テストコメントです',
        ]);
        //コメントは送信されずログインページに遷移したことを確認
        $response->assertRedirect('/login');
    }

    /**
     *  ID9-3:コメントが入力されていない場合、バリデーションメッセージが表示される
     */
    public function testNonComment(){
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
        //商品ページにアクセスして空のコメントをする
        $response = $this->get('/item/1');
        $response->assertStatus(200);
        $commentContent = '';
        $response = $this->post('/item/1/comment', [
            'content' => $commentContent,
        ]);
        $response->assertRedirect('/item/1');
        $response->assertSessionHasErrors(['content' => 'コメントを入力してください']);
    }

    /**
     *  ID9-4:コメントが255字以上の場合、バリデーションメッセージが表示される
     */
    public function testOverStringComment(){
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
        //商品ページにアクセスして255文字以上のコメントをする
        $response = $this->get('/item/1');
        $response->assertStatus(200);
        $commentContent = '';
        for($i=0; $i<30; $i++){
            $commentContent .= "AAAAAAAAAA";
        }
        $response = $this->post('/item/1/comment', [
            'content' => $commentContent,
        ]);
        $response->assertRedirect('/item/1');
        $response->assertSessionHasErrors(['content' => 'コメントは255文字以内で入力してください']);
    }
}
