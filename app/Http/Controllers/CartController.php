<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Merchandise;

class CartController extends Controller
{
    /**
     *  購物車首頁
     * 
     *  @return View
     */
    public function home() {
        return view('cart');
    }
    /**
     *  顯示購物車內所有商品
     * 
     *  @param Request $request
     *  @return Response
     */
    public function index(Request $request) {
        $status = 0; // 回傳狀態碼
        $retVal = ''; // 回傳訊息
        $currentPage = $request->input('page', 1); // 當前頁數
        $recordNumsPerPage = 6; // 每頁筆數
        $skipRecordNums = ($currentPage - 1) * $recordNumsPerPage; // 跳過筆數
        $totalRecordNums = 0; // 總筆數
        $totalPage = 0; // 總頁數
        $userId = is_array($request->session()->get('user')) && !empty($request->session()->get('user')) ? $request->session()->get('user')['id'] : ''; // 使用者編號
        $cartRecords = []; // 購物車資料

        if ($status == 0) {
            if (!isset($userId) || empty($userId)) {
                $status = -1;
                $retVal = '請先登入會員!';
            }
        }

        if ($status == 0) {
            $totalRecordNums = count(Cart::where('user_id', $userId)->get());
            $totalPage = ceil($totalRecordNums / $recordNumsPerPage);
            $cartRecords = Merchandise::join('carts', 'merchandises.id', '=', 'carts.merchandise_id')->where('carts.user_id', $userId)->orderBy('carts.id', 'asc')->skip($skipRecordNums)->take($recordNumsPerPage)->select('merchandises.name', 'merchandises.photo', 'carts.id', 'carts.purchasing_qty', 'carts.purchasing_unit_price')->get();
        }

        return response(view('result', ['result' => json_encode(['status' => $status, 'ret_val' => $retVal, 'current_page' => $currentPage, 'record_nums_per_page' => $recordNumsPerPage, 'total_record_nums' => $totalRecordNums, 'total_page' => $totalPage, 'cart_records' => $cartRecords])]), 200)->header('Content-Type', 'application/json');
    }
    /**
     *  將商品加入購物車
     * 
     *  @param Request $request
     *  @return Response
     */
    public function store(Request $request) {
        $status = 0; // 回傳狀態碼
        $retVal = ''; // 回傳訊息
        $userId = is_array($request->session()->get('user')) && !empty($request->session()->get('user')) ? $request->session()->get('user')['id'] : ''; // 使用者編號
        $merchandiseId = $request->input('merchandise_id', ''); // 商品編號
        $purchasingQty = $request->input('qty', 0); // 購買數量

        if ($status == 0) {
            if (!isset($userId) || empty($userId)) {
                $status = -1;
                $retVal = '您未登入會員!';
            }
        }

        if ($status == 0) {
            if (!isset($merchandiseId) || empty($merchandiseId)) {
                $status = -2;
                $retVal = '未指定商品編號!';
            }
        }

        if ($status == 0) {
            if (!is_numeric($purchasingQty) || substr(strrchr($purchasingQty, '.'), 0, 1) === '.' || $purchasingQty < 1) {
                $status = -3;
                $retVal = '您未指定購買數量或購買數量不正確!';
            }
        }

        if ($status == 0) {
            $cart = Cart::where('user_id', $userId)->where('merchandise_id', $merchandiseId)->first();
            if (isset($cart) && !empty($cart)) {
                $cart->purchasing_qty = intval($cart->purchasing_qty) + intval($purchasingQty);
                $cart->save();
            } else {
                $merchandise = Merchandise::find($merchandiseId);
                $cartModel = new Cart();
                $cartModel->user_id = $userId;
                $cartModel->merchandise_id = $merchandiseId;
                $cartModel->purchasing_qty = $purchasingQty;
                $cartModel->purchasing_unit_price = $merchandise->price;
                $cartModel->save();
            }
            $retVal = '商品已成功加入購物車!';
        }

        return response(view('result', ['result' => json_encode(['status' => $status, 'ret_val' => $retVal])]), 200)->header('Content-Type', 'application/json');
    }
    /**
     *  刪除購物車中一筆資料
     * 
     *  @param Request $request
     *  @return Response
     */
    public function delete(Request $request) {
        $status = 0; // 回傳狀態碼
        $retVal = ''; // 回傳訊息
        $cartId = $request->input('cart_id', ''); // 購物車編號

        if ($status == 0) {
            if (!isset($cartId) || empty($cartId)) {
                $status = -1;
                $retVal = '未指定購物車編號!';
            }
        }

        if ($status == 0) {
            $cart = Cart::find($cartId);
            $cart->delete();
            $retVal = '刪除成功!';
        }

        return response(view('result', ['result' => json_encode(['status' => $status, 'ret_val' => $retVal])]), 200)->header('Content-Type', 'application/json');
    }
}
