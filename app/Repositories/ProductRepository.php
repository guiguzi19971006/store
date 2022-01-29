<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    /**
     *  新增產品
     * 
     *  @param array $input
     * 
     *  @return mixed
     */
    public function store(array $input)
    {
        return Product::create($input);
    }
    /**
     *  確認資料表中是否存在相同名稱之產品
     * 
     *  @param string $product_name
     * 
     *  @return bool
     */
    public function product_exists(string $product_name)
    {
        $product = Product::where('name', $product_name)->first();
        return empty($product) ? false : true;
    }
    /**
     *  取得所有產品
     * 
     *  @param string $order_by
     *  @param bool $ascending
     * 
     *  @return mixed
     */
    public function index(string $order_by, bool $ascending)
    {
        $sort_type = $ascending === true ? 'asc' : 'desc';
        return Product::orderBy($order_by, $sort_type)->get();
    }
}