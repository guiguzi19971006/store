<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class AdminAuthController extends Controller
{
    /**
     *  @var \App\Services\UserService
     */
    public $user_service;
    /**
     *  建立 \App\Services\UserService 實體
     * 
     *  @param \App\Services\UserService $user_service
     * 
     *  @return void
     */
    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }
    /**
     *  管理者登入頁面
     * 
     *  @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function login()
    {
        return view('admin.login');
    }
    /**
     *  管理者登入
     * 
     *  @param \Illuminate\Http\Request $request
     * 
     *  @return \Illuminate\Http\JsonResponse
     */
    public function login_process(Request $request)
    {
        $email = $request->input('email', '');
        $password = $request->input('password', '');
        $input = [
            'email' => $email, 
            'password' => $password
        ];
        $response = $this->user_service->user_login($input);
        // 登入成功
        if (!array_key_exists('errors', $response)) {
            if ($request->session()->has('admin')) {
                $request->session()->forget('admin');
            }

            $request->session()->put('admin', [
                'id' => $response['data']->id, 
                'email' => $response['data']->email, 
                'first_name' => $response['data']->first_name, 
                'last_name' => $response['data']->last_name
            ]);
            
            unset($response['data']);
        }

        return response()->json($response);
    }
    /**
     *  管理者登出
     * 
     *  @param \Illuminate\Http\Request $request
     * 
     *  @return \Illuminate\Http\JsonResponse
     */
    public function logout_process(Request $request)
    {
        if (!$request->session()->has('admin')) {
            return response()->json(['code' => -1, 'message' => '您尚未登入，無須登出!']);
        }

        $request->session()->forget('admin');

        return response()->json(['code' => 0, 'message' => '您已成功登出!']);
    }
    /**
     *  管理者忘記密碼
     * 
     *  @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function forget_password()
    {
        return view('admin.forget_password');
    }
    /**
     *  產生忘記密碼 token
     * 
     *  @param \Illuminate\Http\Request $request
     * 
     *  @return \Illuminate\Http\JsonResponse
     */
    public function generate_user_forget_password_token(Request $request)
    {
        $email = $request->input('email', '');

        $response = $this->user_service->generate_user_token($email, UserService::USER_TOKEN_TYPES['forget_password']);

        if (!array_key_exists('errors', $response)) {
            if ($request->session()->has('email_for_user_forget_password_token')) {
                $request->session()->forget('email_for_user_forget_password_token');
            }
            $request->session()->put('email_for_user_forget_password_token', $email);
        }
        
        return response()->json($response);
    }
    /**
     *  重設密碼頁面
     * 
     *  @param \Illuminate\Http\Request $request
     *  @param string $token
     * 
     *  @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function reset_password(Request $request, string $token)
    {
        $email = $request->session()->get('email_for_user_forget_password_token') ?? '';

        if (!$this->user_service->verify_user_token($email, UserService::USER_TOKEN_TYPES['forget_password'], $token)) {
            abort(404);
        }

        return view('admin.reset_password');
    }
}
