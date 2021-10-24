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
        // 確認是否已存在相同名稱之產品
        if ($this->product_repository->product_exists($input['name'])) {
            return [
                'code' => -1, 
                'message' => '已存在相同名稱之產品!'
            ];
        }
        // 新增產品
        $this->product_repository->store($input);

        return [
            'code' => 0, 
            'message' => '新增成功!'
        ];
    }
}