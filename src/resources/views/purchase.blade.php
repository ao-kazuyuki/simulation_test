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
        $path = 'storage/user_' . $item->user_id . '/item_' . $item->id . '/img_src.jpg';
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

    <div class="buy-content">
        <div class="buy-content__left">
            <div style="display:flex;">
                <img class="buy-content__img" src="{{ asset( $path ) }}">
                <div class="buy-content__item-info">
                    <div class="buy-content__item-name">{{ $item->name }}</div>
                    <div class="detail-content__price-group">
                        <div class="buy-content__currency">￥</div>
                        <div class="buy-content__item-price">{{ number_format($item->price) }}</div>
                    </div>
                </div>
            </div>
            <div class="line"></div>
            <form action="{{ '/purchase/address/' . $item->id }}" method="post">
                @csrf
                <div style="margin-bottom: 64px;">
                    <div class="buy-content__section">支払い方法</div>
                    <select id="payment" class="buy-content__selecter" name="payment">
                        <option value="" selected>選択してください</option>
                        @foreach($payments as $payment)
                            <option value="{{ $payment->id }}" {{ $selectPaymentValue == $payment->id ? 'selected' : '' }}>{{ $payment->content }}</option>
                        @endforeach
                    </select>
                    <div style="margin-left:95px;" class="buy-content__error">@error('payment_value') {{ $message }} @enderror</div>
                </div>
                <div class="line"></div>
                <div class="buy-content__delivery-group">
                <div class="buy-content__section">配送先</div>
                <div class="buy-content__change-delivery">
                    <input type="hidden" name="post_code" value="{{ $postCode }}">
                    <input type="hidden" name="address" value="{{ $addr }}">
                    <input type="hidden" name="building" value="{{ $building }}">
                    <button class="buy-content__change-button" type="submit">変更する</button>
                </div>
            </form>
            </div>
            <div style="display:flex;margin-bottom:60px;margin-left:95px;align-items:center;">
                <input class="buy-content__radio" type="radio" id="delivery-radio" name="delivery-radio" {{ $selectedStateDelivery }}>
                <div class="buy-content__user-address">
                    <div class="buy-content__string">{{ $postCode }}</div>
                    <div class="buy-content__string">{{ $addr . $building }}</div>
                    <span class="buy-content__error">@error('check_delivery') {{ $message }} @enderror</span>
                </div>
            </div>
            <div class="line"></div>
        </div>
        <form action="{{ '/purchase/' . $item->id }}" method="post">
            @csrf
            <input type="radio" id="check_delivery" name="check_delivery" style="display:none;" {{ $selectedStateDelivery }}>
            <input type="hidden" name="payment_value" id="payment_value" value="{{ $selectPaymentValue }}">
            <input type="hidden" name="post_code" value="{{ $postCode }}">
            <input type="hidden" name="address" value="{{ $addr }}">
            <input type="hidden" name="building" value="{{ $building }}">
            <div class="buy-content__right">
                <table class="buy-content__table">
                    <tr>
                        <th class="buy-content__string">商品代金</th>
                        <td><span class="buy-content__currency">￥</span><span class="buy-content__item-price">{{ number_format($item->price) }}</span></td>
                    </tr>
                    <tr>
                        <th class="buy-content__string">支払い方法</th>
                        <td><span id="selected-payment" class="buy-content__string">{{ $paymentType }}</span></td>
                    </tr>
                </table>
                <button type="submit" class="buy-content__button">購入する</button>
            </div>
        </form>
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

