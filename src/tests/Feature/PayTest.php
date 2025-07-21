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
        //todo
    }
}
