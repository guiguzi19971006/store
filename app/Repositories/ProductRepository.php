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
     *  修改產品
     * 
     *  @param array $input
     *  @param \App\Models\Product $product
     * 
     *  @return bool
     */
    public function update(array $input, Product $product)
    {
        return $product->update($input);
    }
    /**
     *  刪除產品
     * 
     *  @param \App\Models\Product $product
     * 
     *  @return bool|null
     */
    public function destroy(Product $product)
    {
        return $product->delete();
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
     *  @param int $row_nums
     * 
     *  @return mixed
     */
    public function index(string $order_by, bool $ascending, int $row_nums)
    {
        $sort_type = $ascending === true ? 'asc' : 'desc';
        return Product::orderBy($order_by, $sort_type)->paginate($row_nums);
    }
}