<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Hash;

class UserService
{
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
}