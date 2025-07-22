<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class PayTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    public function testPaymentTypeChanged(){
        //Featureテスト内でのテストを想定していましたがJavaScriptを使って、支払方法の即時変更処理を実装していたため、Featureテストでこのテストを実現できませんでした。
    }
}
