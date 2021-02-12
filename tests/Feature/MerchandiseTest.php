<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Merchandise;

class MerchandiseTest extends TestCase
{
    /**
     * 測試 - 顯示分頁內所有商品
     *
     * @return void
     */
    public function test_index()
    {
        $response = $this->postJson(route('merchandise.index'), ['page' => 1]);
        $response->assertJson([
            'status' => 0, 
            'ret_val' => '', 
            'merchandises' => [], 
            'current_page' => 1, 
            'row_nums' => 7, 
            'total_page' => 2
        ]);
    }
    /**
     * 測試 - 顯示單一商品
     *
     * @return void
     */
    public function test_show() {
        $response = $this->getJson(route('merchandise.show', ['id' => 1]));
        $response->assertStatus(200);
    }
    /**
     * 測試 - 商品搜尋頁面
     *
     * @return void
     */
    public function test_search() {
        $response = $this->getJson(route('merchandise.search'), [
            'search-keyword-input' => 'A', 
            'search-min-price-input' => 20000, 
            'search-max-price-input' => 40000, 
            'put-on-init-date' => '2020-07-01', 
            'put-on-end-date' => ''
        ]);
        $response->assertStatus(200);
    }
}
