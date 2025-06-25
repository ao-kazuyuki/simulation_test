<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prms = array(
            '良好',
            '目立った傷や汚れなし',
            'やや傷や汚れあり',
            '状態が悪い'
        );
        foreach($prms as $prm){
            self::setSeederData($prm);
        }
    }

    public static function setSeederData($content){
        DB::table('conditions')->insert(['content' => $content]);
    }

}
