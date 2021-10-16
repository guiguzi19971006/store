<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Validator;

class ProductService
{
    public $product_repository;

    public function __construct(ProductRepository $product_repository)
    {
        $this->product_repository = $product_repository;
    }

    public function store($input)
    {
        $validator = Validator::make($input, [
            'name' => 'required|max:20', 
            'price' => 'regex:/^\d+$/', 
            'description' => 'required', 
            'remaining_qty' => 'regex:/^\d+$/', 
            'manufacture_date' => 'required|date|before:today', 
            'expiration_date' => 'required|date|after:today', 
            'is_sellable' => 'regex:/^(Y|N)$/'
        ]);

        if ($validator->fails()) {
            return [
                'code' => -1, 
                'message' => '資料格式錯誤或未填寫!'
            ];
        }

        $this->product_repository->store($input);

        return [
            'code' => 0, 
            'message' => '新增成功!'
        ];
    }
}