<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function store($input)
    {
        $created_product = Product::create($input);
        return $created_product;
    }

    public function product_exists($product_name)
    {
        $product = Product::where('name', $product_name)->first();
        return empty($product) ? false : true;
    }
}