<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'payment_value' => 'required',
            'check_delivery' => 'required',
        ];
    }

    public function messages(){
        return[
            'payment_value.required' => '支払い方法を選択してください',
            'check_delivery.required' => '配送先を選択してください',
        ];
    }

}
