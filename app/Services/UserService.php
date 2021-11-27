<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Mail\UserForgetPasswordToken;
use Hash;
use Mail;

class UserService
{
    public const USER_TOKEN_TYPES = [
        'forget_password' => 1, 
        'register' => 2
    ];
    public $user_repository;

    public function __construct(UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    public function user_login($input)
    {
        $user = $this->user_repository->get_user_by_email($input['email']);

        if (empty($user)) {
            return [
                'errors' => ['email' => '電子郵件錯誤!']
            ];
        }

        if (!Hash::check($input['password'], $user->password)) {
            return [
                'errors' => ['password' => '密碼錯誤!']
            ];
        }

        return [
            'code' => 0, 
            'message' => '登入成功!', 
            'data' => $user
        ];
    }

    public function generate_user_tokens($email, $user_token_type_id)
    {
        $user = $this->user_repository->get_user_by_email($email);

        if (empty($user)) {
            return [
                'errors' => '該電子郵件未被使用!'
            ];
        }

        $seeds = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $user_token_content = '';        
        for ($i = 0; $i < 20; $i++) {
            $user_token_content .= $seeds[rand(0, strlen($seeds) - 1)];
        }

        $user_token_id = $this->user_repository->generate_user_tokens([
            'user_id' => $user->id, 
            'user_token_type_id' => $user_token_type_id, 
            'content' => $user_token_content, 
            'activated_time' => now(), 
            'expiration_time' => now()->addMinutes(10), 
            'created_at' => now(), 
            'updated_at' => now()
        ]);
        $user_token = $this->user_repository->get_user_token_by_id($user_token_id);

        if (empty($user_token)) {
            return [
                'errors' => '查無此使用者驗證碼!'
            ];
        }

        Mail::to($email)->send(new UserForgetPasswordToken($user_token));

        return [
            'code' => 0, 
            'message' => '已寄發驗證碼至您的電子郵件!'
        ];
    }
}