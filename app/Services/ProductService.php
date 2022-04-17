<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Models\Product;

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
    /**
     *  修改產品
     * 
     *  @param array $input
     *  @param \App\Models\Product $product
     * 
     *  @return array
     */
    public function update(array $input, Product $product)
    {
        // 修改產品
        $this->product_repository->update($input, $product);

        return [
            'code' => 0, 
            'message' => '修改成功!'
        ];
    }
    /**
     *  取得所有產品
     * 
     *  @param string $order_by
     *  @param bool $ascending
     *  @param int $row_nums
     * 
     *  @return mixed
     */
    public function index(string $order_by = 'created_at', bool $ascending = true, int $row_nums = 10)
    {
        return $this->product_repository->index($order_by, $ascending, $row_nums);
    }
}