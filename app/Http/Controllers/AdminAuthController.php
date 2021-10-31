<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class AdminAuthController extends Controller
{
    public $user_service;

    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }

    public function login()
    {
        return view('admin.login');
    }

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
}
