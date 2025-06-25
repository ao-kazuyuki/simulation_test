<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prms = array('コンビニ払い', 'カード支払い');
        foreach($prms as $prm){
            self::setSeederData($prm);
        }
    }

    public static function setSeederData($content){
        DB::table('payments')->insert(['content' => $content]);
    }
}
