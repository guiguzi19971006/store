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
}