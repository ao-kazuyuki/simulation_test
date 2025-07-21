<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class SellTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    /**
     *  ID15-1:商品出品画面にて必要な情報が保存できること（カテゴリ、商品の状態、商品名、商品の説明、販売価格）
     */
    public function testSellItem(){
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
        //出品画面を表示して出品処理を行う
        $path = storage_path('app/public/user_1/item_1/img_src.jpg');
        $file = new UploadedFile($path, 'sample.jpg', 'image/jpeg', null, true);   //ダミー画像
        $setCondition = 1;
        $setCategoriesNum = [1, 2, 3];
        $setItemName = 'マイアイテム';
        $setExplanation = '商品の説明です';
        $setPrice = 100;
        $response = $this->get('/sell');
        $response = $this->post('/sell', [
            'img_src' => 'img_src.jpg',
            'img_file' => $file,
            'condition' => $setCondition,
            'category_group' => $setCategoriesNum,
            'name' => $setItemName,
            'brand' => 'マイブランド',
            'explanation' => $setExplanation,
            'price' => $setPrice,
        ]);
        $item = Item::with(['categories','condition'])->where('user_id', '=', $user->id)->get();
        //レコードのカラムが各設定値と一致するか確認
        $categories = $item->toArray()[0]['categories'];
        for($i=0; $i<count($setCategoriesNum); $i++){
            $this->assertEquals($setCategoriesNum[$i], $categories[$i]['id']);
        }
        $condition = $item->toArray()[0]['condition'];
        $this->assertEquals($setCondition, $condition['id']);
        $itemName = $item->toArray()[0]['name'];
        $this->assertEquals($setItemName, $itemName);
        $explanation = $item->toArray()[0]['explanation'];
        $this->assertEquals($setExplanation, $explanation);
        $price = $item->toArray()[0]['price'];
        $this->assertEquals($setPrice, $price);
    }

}
