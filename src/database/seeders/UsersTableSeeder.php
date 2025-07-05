<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Item;
use \Database\Seeders\CategoryItemTableSeeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $itemConditionArr = [ 1, 2, 3, 4, 1, 2, 3, 4, 1, 2 ];
        $itemNameArr = [ '腕時計', 'HDD', '玉ねぎ3束', '革靴', 'ノートPC', 'マイク', 'ショルダーバッグ', 'タンブラー', 'コーヒーミル', 'メイクセット' ];
        $itemExplanationArr = ['スタイリッシュなデザインのメンズ腕時計', '高速で信頼性の高いハードディスク', '新鮮な玉ねぎ3束のセット', 'クラシックなデザインの革靴', '高性能なノートパソコン', '高音質のレコーディング用マイク', 'おしゃれなショルダーバッグ', '使いやすいタンブラー', '手動のコーヒーミル', '便利なメイクアップセット' ];
        $itemPriceArr = [ '15000', '5000', '300', '4000', '45000', '8000', '3500', '500', '4000', '2500' ];
        $itemCategoryArr = [ 5, 2, 10, 5, 2, 2, 4, 10, 2, 6 ];

        for($i=0;$i<10;$i++){
            $user = User::factory()->create();
            $item = Item::factory()->create([
                'user_id' => $user->id,
                'condition_id' => $itemConditionArr[ $i ],
                'name' => $itemNameArr[ $i ],
                'explanation' => $itemExplanationArr[ $i ],
                'price' => $itemPriceArr[ $i ]
            ]);
            $categoryItem = new CategoryItemTableSeeder();
            $categoryItem->runWithData( $item->id, $itemCategoryArr[ $i ] );
        }

    }
}
