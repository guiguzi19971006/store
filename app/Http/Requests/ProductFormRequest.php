<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductFormRequest extends FormRequest
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
     *  覆寫 \Illuminate\Foundation\Http\FormRequest 之 failedValidation 方法: 當欄位資料格式驗證失敗時，強制回傳 JSON 格式之錯誤訊息。
     * 
     *  @param \Illuminate\Contracts\Validation\Validator $validator
     * 
     *  @return void
     */
    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json(['errors' => $errors], 200)
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:20', 
            'price' => 'required|regex:/^\d+$/', 
            'description' => 'required', 
            'remaining_qty' => 'required|regex:/^\d+$/', 
            'manufacture_date' => 'required|date|before:today', 
            'expiration_date' => 'required|date|after:today', 
            'is_sellable' => 'required|regex:/^[YN]{1}$/'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => '產品名稱為必填欄位', 
            'name.max' => '產品名稱長度不可大於 20 字', 
            'price.required' => '產品價格為必填欄位', 
            'price.regex' => '產品價格須為正整數', 
            'description.required' => '產品描述為必填欄位', 
            'remaining_qty.required' => '產品庫存量為必填欄位', 
            'remaining_qty.regex' => '產品庫存量須為正整數', 
            'manufacture_date.required' => '產品製造日期為必填欄位', 
            'manufacture_date.date' => '產品製造日期須為 YYYY-MM-DD 之日期格式', 
            'manufacture_date.before' => '產品製造日期須為今日之前', 
            'expiration_date.required' => '產品有效日期為必填欄位', 
            'expiration_date.date' => '產品有效日期須為 YYYY-MM-DD 之日期格式', 
            'expiration_date.after' => '產品有效日期須為今日之後', 
            'is_sellable.required' => '產品可否販售為必填欄位', 
            'is_sellable.regex' => '產品可否販售須為 Y 或 N'
        ];
    }
}
