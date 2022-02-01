<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Requests\ProductFormRequest;

class ProductController extends Controller
{
    /**
     *  @var \App\Services\ProductService
     */
    public $product_service;
    /**
     *  建立 \App\Services\ProductService 實體
     * 
     *  @param \App\Services\ProductService $product_service
     * 
     *  @return void
     */
    public function __construct(ProductService $product_service)
    {
        $this->product_service = $product_service;
    }
    /**
     *  新增產品頁面
     * 
     *  @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        return view('admin.product.create');
    }
    /**
     *  新增產品
     * 
     *  @param \App\Http\Requests\ProductFormRequest $request
     * 
     *  @return \Illuminate\Http\JsonResponse
     */
    public function store(ProductFormRequest $request)
    {
        $validated_data = $request->validated();
        $response = $this->product_service->store($validated_data);
        return response()->json($response);
    }
    /**
     *  顯示所有產品頁面
     * 
     *  @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $products = $this->product_service->index();
        return view('admin.product.index', ['products' => $products]);
    }
}
