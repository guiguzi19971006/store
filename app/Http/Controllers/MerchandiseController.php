<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Merchandise;

class MerchandiseController extends Controller
{
    /**
     *  首頁
     * 
     *  @return View
     */
    public function home() {
        return view('home');
    }
    /**
     *  顯示分頁內所有商品
     * 
     *  @return Response
     */
    public function index(Request $request) {
        $status = 0; // 回傳狀態碼
        $retVal = ''; // 回傳訊息
        $currentPage = $request->input('page', 1); // 回傳當前頁數
        $perPageRowNums = 6; // 每頁 6 筆資料
        $skipRowNums = ($currentPage - 1) * $perPageRowNums; // 跳過筆數
        $merchandises = Merchandise::orderBy('id', 'asc')->skip($skipRowNums)->take($perPageRowNums)->get(); // 回傳資料
        $rowNums = count(Merchandise::all()); // 回傳商品總數
        $totalPage = ceil($rowNums / $perPageRowNums); // 回傳總頁數
        return response(view('result', ['result' => json_encode(['status' => $status, 'ret_val' => $retVal, 'merchandises' => $merchandises, 'current_page' => $currentPage, 'row_nums' => $rowNums, 'total_page' => $totalPage])]), 200)->header('Content-Type', 'application/json');
    }
    /**
     *  顯示單一商品
     * 
     *  @param string id 商品編號
     *  @return View
     */
    public function show($id) {
        $status = 0; // 回傳狀態碼
        $retVal = ''; // 回傳訊息
        if ($status == 0) {
            if (!isset($id) || empty($id)) {
                $retVal = '未指定商品編號!';
                $status = -1;
            }
        }

        if ($status == 0) {
            $merchandise = Merchandise::find($id); // 取得單一商品資訊
        }

        return view('merchandise', ['merchandise' => $merchandise]);
    }
    /**
     *  商品搜尋頁面
     * 
     *  @param Request $request
     *  @param integer $page 頁碼
     *  @return View
     */
    public function search(Request $request) {
        $searchKeyword = $request->input('search-keyword-input', ''); // 關鍵字
        $minPrice = $request->input('search-min-price-input', 0); // 最低價
        $maxPrice = $request->input('search-max-price-input', 0); // 最高價
        $putOnInitDate = $request->input('put-on-init-date', ''); // 上架起始日
        $putOnEndDate = $request->input('put-on-end-date', ''); // 上架結束日
        $merchandises = [];
        if (empty($searchKeyword) && empty($minPrice) && empty($maxPrice) && empty($putOnInitDate) && empty($putOnEndDate)) {
            $merchandises = Merchandise::orderBy('id', 'asc')->get();
        } else {
            $searchCondition = Merchandise::where('id', '<>', 0);
            if (!empty($searchKeyword)) {
                $searchCondition = $searchCondition->where('name', 'like', '%' . $searchKeyword . '%');
            }
            if (!empty($minPrice)) {
                $searchCondition = $searchCondition->where('price', '>=', $minPrice);
            }
            if (!empty($maxPrice)) {
                $searchCondition = $searchCondition->where('price', '<=', $maxPrice);
            }
            if (!empty($putOnInitDate)) {
                $searchCondition = $searchCondition->where('created_at', '>=', $putOnInitDate);
            }
            if (!empty($maxPrice)) {
                $searchCondition = $searchCondition->where('created_at', '<=', $putOnEndDate);
            }
            $merchandises = $searchCondition->orderBy('id', 'asc')->get();
        }
        return view('searchPage', ['merchandises' => $merchandises]);
    }
}
