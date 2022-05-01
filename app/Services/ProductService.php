<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Repositories\PhotoRepository;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    /**
     *  @var \App\Repositories\ProductRepository
     */
    public $product_repository;
    /**
     *  @var \App\Repositories\PhotoRepository
     */
    public $photo_repository;
    /**
     *  建立 \App\Repositories\ProductRepository 與 \App\Repositories\PhotoRepository 實體
     * 
     *  @param \App\Repositories\ProductRepository $product_repository
     *  @param \App\Repositories\PhotoRepository $photo_repository
     * 
     *  @return void
     */
    public function __construct(ProductRepository $product_repository, PhotoRepository $photo_repository)
    {
        $this->product_repository = $product_repository;
        $this->photo_repository = $photo_repository;
    }
    /**
     *  新增產品
     * 
     *  @param array $input
     * 
     *  @return array
     */
    public function store(array $input)
    {
        // 確認是否已存在相同名稱之產品
        if ($this->product_repository->product_exists($input['name'])) {
            return [
                'code' => -1, 
                'message' => '已存在相同名稱之產品!'
            ];
        }
        // 確認是否已存在相同名稱之產品相片
        $product_photo_path = 'product/' . $input['photo']->getClientOriginalName();
        if ($this->photo_repository->photo_exists(Product::class, $product_photo_path) || Storage::disk('photos')->exists($product_photo_path)) {
            return [
                'code' => -2, 
                'message' => '已存在相同名稱之產品相片!'
            ];
        }
        // 上傳產品相片
        if (!Storage::disk('photos')->put($product_photo_path, $input['photo']->get())) {
            return [
                'code' => -3, 
                'message' => '產品相片上傳失敗!'
            ];
        }
        // 新增產品
        unset($input['photo']);
        $product = $this->product_repository->store($input);
        // 新增產品相片
        $this->photo_repository->store([
            'imageable_type' => Product::class, 
            'imageable_id' => $product->id, 
            'path' => $product_photo_path
        ]);

        return [
            'code' => 0, 
            'message' => '新增成功!'
        ];
    }
    /**
     *  修改產品
     * 
     *  @param array $input
     *  @param \App\Models\Product $product
     * 
     *  @return array
     */
    public function update(array $input, Product $product)
    {
        if (!$this->product_repository->update($input, $product)) {
            return [
                'code' => -1, 
                'message' => '修改失敗!'
            ];
        }

        return [
            'code' => 0, 
            'message' => '修改成功!'
        ];
    }
    /**
     *  刪除產品
     * 
     *  @param \App\Models\Product $product
     * 
     *  @return array
     */
    public function destroy(Product $product)
    {
        if (!$this->product_repository->destroy($product)) {
            return [
                'code' => -1, 
                'message' => '刪除失敗!'
            ];
        }

        return [
            'code' => 0, 
            'message' => '刪除成功!'
        ];
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
    public function index(string $order_by = 'created_at', bool $ascending = true, int $row_nums = 10)
    {
        return $this->product_repository->index($order_by, $ascending, $row_nums);
    }
}