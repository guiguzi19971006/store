<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;

class ProductController extends Controller
{
    public $product_service;

    public function __construct(ProductService $product_service)
    {
        $this->product_service = $product_service;
    }

    public function create()
    {
        return view('admin.product.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $result = $this->product_service->store($input);
        return response()->json($result);
    }
}
