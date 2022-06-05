<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Requests\ProductFormRequest;
use App\Models\Product;

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
     *  修改產品頁面
     * 
     *  @param \App\Models\Product
     * 
     *  @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Product $product)
    {
        return view('admin.product.edit', ['product' => $product, 'photos' => $product->photos]);
    }
    /**
     *  修改產品
     * 
     *  @param \App\Http\Requests\ProductFormRequest $request
     *  @param \App\Models\Product
     * 
     *  @return \Illuminate\Http\JsonResponse
     */
    public function update(ProductFormRequest $request, Product $product)
    {
        $validated_data = $request->validated();
        $response = $this->product_service->update($validated_data, $product);
        return response()->json($response);
    }
    /**
     *  刪除產品
     * 
     *  @param \App\Models\Product $product
     * 
     *  @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        $response = $this->product_service->destroy($product);
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
    /**
     *  顯示單一產品頁面
     * 
     *  @param \App\Models\Product $product
     * 
     *  @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show(Product $product)
    {
        return view('admin.product.show', ['product' => $product, 'photos' => $product->photos]);
    }
    /**
     *  搜尋產品頁面
     * 
     *  @param \Illuminate\Http\Request $request
     * 
     *  @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function search(Request $request)
    {
        $input = $request->all();
        $products = $this->product_service->search($input);
        return view('admin.product.search', ['products' => $products]);
    }
}
