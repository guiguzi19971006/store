<?php

namespace App\Repositories;

use DB;

class ProductRepository
{
    public function store($input)
    {
        $product_id = DB::table('products')->insertGetId($input);
        return $product_id;
    }

    public function product_exists($product_name)
    {
        $product = DB::table('products')->where('name', $product_name)->first();
        return empty($product) ? false : true;
    }
}