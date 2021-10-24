<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Requests\ProductFormRequest;

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

    public function store(ProductFormRequest $request)
    {
        $validated_data = $request->validated();
        $result = $this->product_service->store($validated_data);
        return response()->json($result);
    }
}
