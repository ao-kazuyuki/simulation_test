<?php

namespace App\Http\Controllers;

use App\Models\Buy;
use App\Models\Item;
use App\Models\Payment;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyController extends Controller
{
    public function showBuyView($item_id){
        $user = Auth::user();
        $item = Item::with(['categories', 'condition'])->find($item_id);
        $payments = Payment::all();
        return view('purchase', compact('user', 'item', 'payments'));
    }

    public function showBuyViewChangedAddr(AddressRequest $request, $item_id){
        $user = Auth::user();
        $item = Item::with(['categories', 'condition'])->find($item_id);
        $payments = Payment::all();
        $isChanged = true;
        $paymentValue = $request->paymentValue;
        $changedPostCode = $request->post_code;
        $changedAddress = $request->address;
        $changedBuilding = $request->building;
        return view('purchase', compact('user', 'item', 'payments', 'isChanged', 'paymentValue', 'changedPostCode', 'changedAddress', 'changedBuilding'));
    }

    public function store(PurchaseRequest $request, $item_id){
        $user = Auth::user();
        $buy = Buy::create([
            'item_id' => $item_id,
            'user_id' => $user->id,
            'payment_id' => $request->payment_value,
            'post_code' => $request->post_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);
        return redirect('/')->with('message', '購入手続きが完了しました。');
    }

    public function showChangeAddress(Request $request, $item_id){
        $user = Auth::user();
        $item = Item::with(['categories', 'condition'])->find($item_id);
        return view('address', compact('item', 'request', 'user'));
    }
}
