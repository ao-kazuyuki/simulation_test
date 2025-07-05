<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\CategoryItem;

class CategoryItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    }

    public static function runWithData( $itemId, $categoryId){
        DB::table('category_item')->insert([
            'category_id' => $categoryId,
            'item_id' => $itemId,
        ]);
    }
}
