<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;

class ActivityController extends Controller
{
    /**
     *  新增使用者瀏覽紀錄
     * 
     *  @param Request $request
     *  @return Response
     */
    public function store(Request $request) {
        $status = 0; // 回傳狀態碼
        $retVal = ''; // 回傳訊息
        $merchandiseId = $request->input('merchandise_id', ''); // 商品編號
        $userId = (is_array($request->session()->get('user')) && !empty($request->session()->get('user'))) ? $request->session()->get('user')['id'] : ''; // 會員編號

        if ($status == 0) {
            if (!isset($merchandiseId) || empty($merchandiseId)) {
                $status = -1;
                $retVal = '未指定商品編號!';
            }
        }

        if ($status == 0) {
            if (!isset($userId) || empty($userId)) {
                $status = -2;
                $retVal = '未指定會員編號!';
            }
        }

        if ($status == 0) {
            $activity = Activity::where('user_id', $userId)->where('merchandise_id', $merchandiseId)->first();
            if (isset($activity) && !empty($activity)) {
                $activity->browsing_cnt = intval($activity->browsing_cnt) + 1;
                $activity->save();
            } else {
                $activityModel = new Activity();
                $activityModel->user_id = $userId;
                $activityModel->merchandise_id = $merchandiseId;
                $activityModel->browsing_cnt = 1;
                $activityModel->save();
            }
            $retVal = '已新增使用者瀏覽紀錄!';
        }

        return response(view('result', ['result' => json_encode(['status' => $status, 'ret_val' => $retVal])]), 200)->header('Content-Type', 'application/json');
    }
}
