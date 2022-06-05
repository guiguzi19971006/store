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
        return Product::where('name', $product_name)->get()->count() > 0;
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
    /**
     *  搜尋產品
     * 
     *  @param array $input
     *  @param string $order_by
     *  @param bool $ascending
     * 
     *  @return mixed
     */
    public function search(array $input, string $order_by, bool $ascending)
    {
        $builder = Product::query();
        // 價格
        if (isset($input['price']) && is_array($input['price'])) {
            if (isset($input['price'][0])) {
                $builder = $builder->where('price', '>=', $input['price'][0]);
            }
    
            if (isset($input['price'][1])) {
                $builder = $builder->where('price', '<=', $input['price'][1]);
            }
        }
        // 庫存量
        if (isset($input['remaining_qty']) && is_array($input['remaining_qty'])) {
            if (isset($input['remaining_qty'][0])) {
                $builder = $builder->where('remaining_qty', '>=', $input['remaining_qty'][0]);
            }

            if (isset($input['remaining_qty'][1])) {
                $builder = $builder->where('remaining_qty', '<=', $input['remaining_qty'][1]);
            }
        }
        // 製造日期
        if (isset($input['manufacture_date']) && is_array($input['manufacture_date'])) {
            if (isset($input['manufacture_date'][0])) {
                $builder = $builder->where('manufacture_date', '>=', $input['manufacture_date'][0]);
            }
    
            if (isset($input['manufacture_date'][1])) {
                $builder = $builder->where('manufacture_date', '<=', $input['manufacture_date'][1]);
            }
        }
        // 有效日期
        if (isset($input['expiration_date']) && is_array($input['expiration_date'])) {
            if (isset($input['expiration_date'][0])) {
                $builder = $builder->where('expiration_date', '>=', $input['expiration_date'][0]);
            }
    
            if (isset($input['expiration_date'][1])) {
                $builder = $builder->where('expiration_date', '<=', $input['expiration_date'][1]);
            }
        }
        // 可否販售
        if (isset($input['is_sellable'])) {
            $builder = $builder->where('is_sellable', $input['is_sellable']);
        }
        // 建立時間
        if (isset($input['created_at']) && is_array($input['created_at'])) {
            if (isset($input['created_at'][0])) {
                $builder = $builder->where('created_at', '>=', $input['created_at'][0]);
            }
    
            if (isset($input['created_at'][1])) {
                $builder = $builder->where('created_at', '<=', $input['created_at'][1]);
            }
        }
        // 更新時間
        if (isset($input['updated_at']) && is_array($input['updated_at'])) {
            if (isset($input['updated_at'][0])) {
                $builder = $builder->where('updated_at', '>=', $input['updated_at'][0]);
            }
    
            if (isset($input['updated_at'][1])) {
                $builder = $builder->where('updated_at', '<=', $input['updated_at'][1]);
            }
        }
        // 關鍵字
        if (isset($input['keyword'])) {
            $builder = $builder->where(function ($query) use ($input) {
                $query->where('name', 'like', '%' . $input['keyword'] . '%')
                      ->orWhere('description', 'like', '%' . $input['keyword'] . '%');
            });
        }

        return $builder->orderBy($order_by, $ascending === true ? 'asc' : 'desc')->paginate(10);
    }
}