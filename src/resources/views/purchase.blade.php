@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('header-menu')
    @component('components.header-menu')
    @endcomponent
@endsection

@section('content')
    @php
        $path = 'storage/user_' . $item->user_id . '/item_' . $item->id . '/';
        $file = glob($path . '*');
        if(!empty($file)){
            $path .= basename($file[0]);
        }
        if(isset($isChanged)){
            $postCode = $changedPostCode;
            $addr = $changedAddress;
            $building = $changedBuilding;
        }else{
            if(old('post_code') || old('address') || old('building')){
                $postCode = old('post_code');
                $addr = old('address');
                $building = old('building');
            }else{
                $postCode = $user->post_code;
                $addr = $user->address;
                $building = $user->building;
            }
        }

        $selectPaymentValue = "";
        $paymentType = '未選択';
        if(isset($paymentValue)){
            $selectPaymentValue = $paymentValue;
            foreach($payments as $payment){
                if($selectPaymentValue == $payment->id){
                    $paymentType = $payment->content;
                }
            }
        }else{
            foreach($payments as $payment){
                if(old('payment_value') == $payment->id){
                    $selectPaymentValue = $payment->id;
                    $paymentType = $payment->content;
                }
            }
        }

        $selectedStateDelivery = '';
        if($errors->any()){
            if(!$errors->has('check_delivery')){
                $selectedStateDelivery = 'checked';
            }
        }
    @endphp

    <div class="buy-group">
        <!-- コンテンツ(左側) -->
        <div class="buy-layout__left">
            <!-- 商品情報 -->
            <div class="buy-item__group">
                <img class="buy-item__img" src="{{ asset( $path ) }}">
                <div class="buy-item__info">
                    <h1 class="buy-item__section">{{ $item->name }}</h1>
                    <div class="buy-price__group">
                        <span class="buy-currency">￥</span>
                        <span class="buy-price">{{ number_format($item->price) }}</span>
                    </div>
                </div>
            </div>
            <div class="line"></div>
            <form action="{{ '/purchase/address/' . $item->id }}" method="post">
                @csrf
                <!-- 支払い方法 -->
                <div class="payment-group">
                    <h2 class="buy-option__section">支払い方法</h2>
                    <div class="buy-payment__selecter">
                        <select id="payment" name="payment">
                            <option value="" selected hidden>選択してください</option>
                            @foreach($payments as $payment)
                                <option class="buy-payment__drop" value="{{ $payment->id }}" {{ $selectPaymentValue == $payment->id ? 'selected' : '' }}>
                                    {{ $payment->content }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <span class="buy-payment__error">
                        @error('payment_value')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="line"></div>
                <!-- 配送先 -->
                <div class="buy-delivery-group">
                    <h2 class="buy-option__section">配送先</h2>
                    <div class="buy-change__delivery">
                        <input type="hidden" name="post_code" value="{{ $postCode }}">
                        <input type="hidden" name="address" value="{{ $addr }}">
                        <input type="hidden" name="building" value="{{ $building }}">
                        <button class="buy-change__link" type="submit">変更する</button>
                    </div>
                </div>
                <div class="buy-address__group">
                    <input class="buy-radio" type="radio" id="delivery-radio" name="delivery-radio" {{ $selectedStateDelivery }}>
                    <div class="buy-user__address">
                        <div class="buy-text">{{ $postCode }}</div>
                        <div class="buy-text">{{ $addr . $building }}</div>
                        <span class="buy-address__error">
                            @error('check_delivery')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="line"></div>
            </form>
        </div>
        <!-- コンテンツ右側 -->
        <form class="buy-layout__right" action="{{ '/purchase/' . $item->id }}" method="post">
            @csrf
            <input type="radio" id="check_delivery" name="check_delivery" style="display:none;" {{ $selectedStateDelivery }}>
            <input type="hidden" name="payment_value" id="payment_value" value="{{ $selectPaymentValue }}">
            <input type="hidden" name="post_code" value="{{ $postCode }}">
            <input type="hidden" name="address" value="{{ $addr }}">
            <input type="hidden" name="building" value="{{ $building }}">
            <!-- 購入情報の転記 -->
            <table class="buy-table">
                <tr>
                    <th class="buy-text">商品代金</th>
                    <td>
                        <span class="buy-currency">￥</span>
                        <span class="buy-price">{{ number_format($item->price) }}</span>
                    </td>
                </tr>
                <tr>
                    <th class="buy-text">支払い方法</th>
                    <td><span id="selected-payment" class="buy-text">{{ $paymentType }}</span></td>
                </tr>
            </table>
            <!-- 購入ボタン -->
            <button type="submit" class="buy-button">購入する</button>
        </form>
        <!-- 支払い方法の転記と記憶 -->
        <script>
            const deliveryRadio = document.getElementById('delivery-radio');
            const checkDelivery = document.getElementById('check_delivery');
            if(deliveryRadio.checked){
                checkDelivery.checked = true;
            }
            deliveryRadio.addEventListener('change', function(){
                if(deliveryRadio.checked){
                    checkDelivery.checked = true;
                }
            });
            const paymentSelect = document.getElementById('payment');
            const selectedPayment = document.getElementById('selected-payment');
            const paymentValue = document.getElementById('payment_value');
            const payments = @json($payments);
            if(paymentValue.value != ""){
                selectedPayment.textContent = payments[paymentValue.value - 1].content;
            }
            paymentSelect.addEventListener('change', function(){
                let isSelected = false;
                for(let i = 0; i < payments.length; i++){
                    if(payments[i].id==paymentSelect.value){
                        selectedPayment.textContent = payments[i].content;
                        paymentValue.value = paymentSelect.value;
                        console.log( paymentValue.value );
                        isSelected = true;
                        break;
                    }
                }
                if(!isSelected){
                    selectedPayment.textContent = '未選択';
                    paymentValue.value = "";
                }
            });
        </script>
    </div>
@endsection

