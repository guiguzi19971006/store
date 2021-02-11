<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;

class UserController extends Controller
{
    /**
     *  會員註冊頁面
     * 
     *  @return View
     */
    public function register() {
        return view('register');
    }
    /**
     *  會員註冊
     * 
     *  @param Request $request
     *  @return Redirect
     */
    public function registerProcess(Request $request) {
        $status = 0; // 回傳狀態碼
        $retVal = ''; // 回傳訊息
        $errorFormatCssSelector = [];
        // 驗證資料格式是否正確
        if ($status == 0) {
            if (strlen($request->input('name', '')) == 0 || strlen($request->input('name', '')) > 30) {
                $status = -1;
                $retVal = '資料格式不正確!';
                array_push($errorFormatCssSelector, 'input[id="name"]');
            }

            if (!filter_var($request->input('email', ''), FILTER_VALIDATE_EMAIL)) {
                $status = -1;
                $retVal = '資料格式不正確!';
                array_push($errorFormatCssSelector, 'input[id="email"]');
            }

            if (!preg_match('/^[A-Za-z0-9]{8,20}$/', $request->input('password', ''))) {
                $status = -1;
                $retVal = '資料格式不正確!';
                array_push($errorFormatCssSelector, 'input[id="password"]');
            }

            if (!preg_match('/^[09]{2}[0-9]{8}$/', $request->input('phone', ''))) {
                $status = -1;
                $retVal = '資料格式不正確!';
                array_push($errorFormatCssSelector, 'input[id="phone"]');
            }

            if (strlen($request->input('address', '')) == 0 || strlen($request->input('address', '')) > 100) {
                $status = -1;
                $retVal = '資料格式不正確!';
                array_push($errorFormatCssSelector, 'input[id="address"]');
            }

            if (!is_numeric($request->input('age', 0)) || substr(strrchr($request->input('age'), '.'), 0, 1) === '.' || $request->input('age') <= 0) {
                $status = -1;
                $retVal = '資料格式不正確!';
                array_push($errorFormatCssSelector, 'input[id="age"]');
            }
        }
        // 確認該使用者是否重複註冊
        if ($status == 0) {
            $user = User::where('email', $request->input('email'))->orWhere('phone', $request->input('phone'))->first();
            if (isset($user) && !empty($user)) {
                $status = -2;
                $retVal = '您輸入的電子郵件或手機號碼已被使用!';
            }
        }

        if ($status == 0) {
            $userModel = new User();
            $userModel->name = $request->input('name');
            $userModel->email = $request->input('email');
            $userModel->password = Hash::make($request->input('password'));
            $userModel->phone = $request->input('phone');
            $userModel->address = $request->input('address');
            $userModel->age = $request->input('age');
            $userModel->gender = $request->input('gender');
            $userModel->save();
            $retVal = '註冊成功!';
        }
        
        return response(view('result', ['result' => json_encode(['status' => $status, 'ret_val' => $retVal, 'error_format_css_selector' => $errorFormatCssSelector])]), 200)->header('Content-Type', 'application/json');
    }
    /**
     *  會員登入頁面
     * 
     *  @return view
     */
    public function login() {
        return view('login');
    }
    /**
     *  會員登入
     * 
     *  @param Request $request
     *  @return Response
     */
    public function loginProcess(Request $request) {
        $status = 0; // 回傳狀態碼
        $retVal = ''; // 回傳訊息
        $email = $request->input('email', '');
        $password = $request->input('password', '');

        if ($status == 0) {
            $user = User::where('email', $email)->first();
            if (!isset($user) || empty($user)) {
                $status = -1;
                $retVal = '電子郵件錯誤!';
            }
        }

        if ($status == 0) {
            if (!Hash::check($password, $user->password)) {
                $status = -2;
                $retVal = '密碼錯誤!';
            }
        }

        if ($status == 0) {
            $user->last_login_time = date('Y-m-d H:i:s');
            $user->save();
            $request->session()->put('user', [
                'id' => $user->id, 
                'name' => $user->name, 
                'email' => $user->email
            ]);
            $retVal = '登入成功!';
        }

        return response(view('result', ['result' => json_encode(['status' => $status, 'ret_val' => $retVal])]), 200)->header('Content-Type', 'application/json');
    }
    /**
     *  會員登出
     * 
     *  @param Request $request
     *  @return Response
     */
    public function logoutProcess(Request $request) {
        $status = 0; // 回傳狀態碼
        $retVal = ''; // 回傳訊息

        if ($status == 0) {
            if (!is_array($request->session()->get('user')) || empty($request->session()->get('user'))) {
                $status = -1;
                $retVal = '您未登入帳號!';
            }
        }

        if ($status == 0) {
            $request->session()->forget('user');
            $retVal = '您已登出!';
        }

        return response(view('result', ['result' => json_encode(['status' => $status, 'ret_val' => $retVal])]), 200)->header('Content-Type', 'application/json');
    }
    /**
     *  忘記密碼頁面
     * 
     *  @return View
     */
    public function forgetPassword() {
        return view('forgetPassword');
    }
    /**
     *  發送重設密碼連結至使用者電子郵件
     * 
     *  @param Request $request
     *  @return Response
     */
    public function forgetPasswordProcess(Request $request) {
        $status = 0; // 回傳狀態碼
        $retVal = ''; // 回傳訊息
        $resetPasswordToken = ''; // 重設密碼 token
        $email = $request->input('email', '');
        // 確認使用者輸入的電子郵件是否被註冊
        if ($status == 0) {
            $user = User::where('email', $email)->first();
            if (!isset($user) || empty($user)) {
                $status = -1;
                $retVal = '電子郵件錯誤或該電子郵件未被註冊!';
            }
        }
        // 寄送重設密碼連結至使用者電子郵件
        if ($status == 0) {
            do {
                $resetPasswordToken = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 20);
                $userResetPasswordToken = User::where('id', $user->id)->where('reset_password_token', $resetPasswordToken)->first();
            } while (isset($userResetPasswordToken) && !empty($userResetPasswordToken));
            $user->reset_password_token = $resetPasswordToken;
            $user->save();
            Mail::to($user->email)->send(new ResetPasswordMail($user));
            $retVal = '已發送重設密碼連結到您的電子郵件!';
        }

        return response(view('result', ['result' => json_encode(['status' => $status, 'ret_val' => $retVal])]), 200)->header('Content-Type', 'application/json');
    }
    /**
     *  重設密碼頁面
     * 
     *  @return View|Redirect
     */
    public function resetPassword($id, $token) {
        $userResetPasswordToken = User::where('id', $id)->where('reset_password_token', $token)->first();
        if (!isset($userResetPasswordToken) || empty($userResetPasswordToken)) {
            return redirect()->route('user.login');
        }
        return view('resetPassword', ['id' => $id, 'token' => $token]);
    }
    /**
     *  重設密碼
     * 
     *  @param Request $request
     *  @return Response
     */
    public function resetPasswordProcess($id, $token, Request $request) {
        $status = 0; // 回傳狀態碼
        $retVal = ''; // 回傳訊息
        $password = $request->input('password', '');
        $confirmPassword = $request->input('confirm_password', '');

        if ($status == 0) {
            $user = User::where('id', $id)->where('reset_password_token', $token)->first();
            if (!isset($user) || empty($user)) {
                $status = -1;
                $retVal = '重設密碼連結錯誤!';
            }
        }

        if ($status == 0) {
            if (!preg_match('/^[A-Za-z0-9]{8,20}$/', $password)) {
                $status = -2;
                $retVal = '密碼格式不正確!';
            }
        }

        if ($status == 0) {
            if ($confirmPassword != $password) {
                $status = -3;
                $retVal = '兩次密碼輸入不一致!';
            }
        }

        if ($status == 0) {
            $user->password = Hash::make($password);
            $user->reset_password_token = '';
            $user->save();
            $retVal = '密碼已更新!';
        }

        return response(view('result', ['result' => json_encode(['status' => $status, 'ret_val' => $retVal])]), 200)->header('Content-Type', 'application/json');
    }
}
