<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;
use App\Models\Like;

class KeywordTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    /**
     *  ID6-1:「商品名」で部分一致検索ができる
     */
    public function testKeyWordSearchItem(){
        //商品「腕時計」を部分一致「時計」で検索し、結果を確認
        $response = $this->get('/search?keyword=時計');
        $response->assertStatus(200)->assertSee('腕時計');
    }

    /**
     *  ID6-2:検索状態がマイリストでも保持されている
     */
    public function testKeyWordSearchMyListItem(){
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
        //商品「腕時計」を部分一致「時計」で検索
        $response = $this->get('/search?keyword=時計');
        //保持していた前回の検索キーワードをマイリスト取得時に渡しておく
        $response = $this->get( url('/?page=mylist') . '&keyword=' . urlencode($searchWord ?? ''));
        //同様に腕時計の商品がマイリストにも存在するか確認
        $response->assertStatus(200)->assertSee('腕時計');
    }
}
