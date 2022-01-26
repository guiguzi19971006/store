<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService
{
    /**
     *  @var \App\Repositories\ProductRepository
     */
    public $product_repository;
    /**
     *  建立 \App\Repositories\ProductRepository 實體
     * 
     *  @param \App\Repositories\ProductRepository $product_repository
     * 
     *  @return void
     */
    public function __construct(ProductRepository $product_repository)
    {
        $this->product_repository = $product_repository;
    }
    /**
     *  新增產品
     * 
     *  @param array $input
     * 
     *  @return array
     */
    public function store(array $input)
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