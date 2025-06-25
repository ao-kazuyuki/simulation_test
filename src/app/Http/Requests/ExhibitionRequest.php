<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'name' => 'required',
            'explanation' => 'required|max:255',
            'img_file' => 'required|mimes:jpg,jpeg,png',
            'category_group' => ['array'],
            'condition' => 'required',
            'price' => 'required|numeric|min:0'
        ];
    }

    public function messages(){
        return[
            'name.required' => '商品名を入力してください',
            'explanation.required' => '商品の説明を入力してください',
            'explanation.max' => '商品の説明は255文字以内で入力してください',
            'img_file.required' => '商品画像をアップロードしてください',
            'img_file.mimes' => '拡張子はjpegまたはpngを指定してください',
            'condition.required' => '商品の状態を選択してください',
            'price.required' => '販売価格を入力してください',
            'price.numeric' => '販売価格は数値を入力してください',
            'price.min' => '販売価格は0円以上の数値を入力してください'
        ];
    }

    public function withValidator($validator){
        $validator->after(function($validator){
            $categories = $this->input('category_group', []);
            if(empty($categories)){
                $validator->errors()->add('category_group', 'カテゴリーは1つ以上設定してください');
            }
        });
    }

}
