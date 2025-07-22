<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\Buy;
use App\Models\User;
use App\Models\Item;
use App\Models\CategoryItem;

class ItemTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    /**
     *  ID4-1:全商品を取得できる
     */
    public function testGetAllItems(){
        $response = $this->get('/');
        //ダミー商品が全て存在するか確認
        $response->assertStatus(200)
            ->assertSeeText('腕時計')
            ->assertSeeText('HDD')
            ->assertSeeText('玉ねぎ3束')
            ->assertSeeText('革靴')
            ->assertSeeText('ノートPC')
            ->assertSeeText('マイク')
            ->assertSeeText('ショルダーバッグ')
            ->assertSeeText('タンブラー')
            ->assertSeeText('コーヒーミル')
            ->assertSeeText('メイクセット');
    }

    /**
     *  ID4-2:購入済み商品は「Sold」と表示される
     */
    public function testSoldItem(){
        //商品の購入処理
        $buy = Buy::create([
            'item_id' => '1',
            'user_id' => '1',
            'payment_id' => '1',
            'post_code' => '123-4567',
            'address' => '東京都',
            'building' => '〇×マンション123',
        ]);
        $response = $this->get('/');
        //購入済み商品の存在チェック
        $response->assertStatus(200)->assertSeeText('Sold');
    }

    /**
     *  ID4-3:自分が出品した商品は表示されない
     */
    public function testHiddenMySelfItem(){
        //ユーザーを生成
        $user = User::create([
            'name' => 'yamada',
            'email' => 'test@test.jp',
            'password' => Hash::make('12345678'),
        ]);
        //生成したユーザーIDを使って商品を出品
        $item = Item::create([
            'img_src' => 'img_src.jpg',
            'user_id' => $user->id,
            'condition_id' => '1',
            'name' => 'マイアイテム',
            'explanation' => '自分自身が出品した商品',
            'price' => '100',
        ]);
        $categoryItem = CategoryItem::create([
            'category_id' => '1',
            'item_id' => $item->id,
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
        //自分が出品した商品名が存在しない事を確認
        $this->get('/')->assertDontSeeText('マイアイテム');
    }

}
