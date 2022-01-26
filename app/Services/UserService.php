<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Mail\UserForgetPasswordToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserService
{
    /**
     *  @var array
     */
    public const USER_TOKEN_TYPES = [
        'forget_password' => 1, 
        'register' => 2
    ];
    /**
     *  @var \App\Repositories\UserRepository $user_repository
     */
    public $user_repository;
    /**
     *  建立 \App\Repositories\UserRepository 實體
     * 
     *  @param \App\Repositories\UserRepository $user_repository
     * 
     *  @return void
     */
    public function __construct(UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }
    /**
     *  使用者登入
     * 
     *  @param array $input
     * 
     *  @return array
     */
    public function user_login(array $input)
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
    /**
     *  產生使用者 token
     * 
     *  @param string $email
     *  @param int $user_token_type_id
     * 
     *  @return array
     */
    public function generate_user_token(string $email, int $user_token_type_id)
    {
        $user = $this->user_repository->get_user_by_email($email);

        if (empty($user)) {
            return [
                'errors' => ['email' => '您輸入的電子郵件錯誤或未被使用!']
            ];
        }

        $seeds = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $user_token_content = '';        
        for ($i = 0; $i < 20; $i++) {
            $user_token_content .= $seeds[rand(0, strlen($seeds) - 1)];
        }

        if ($this->user_repository->user_token_exists($user->id, $user_token_type_id)) {
            $affected_row_nums = $this->user_repository->update_user_token($user->id, $user_token_type_id, [
                'content' => $user_token_content, 
                'activated_time' => now(), 
                'expiration_time' => now()->addMinutes(10), 
                'updated_at' => now()
            ]);
        } else {
            $user_token_id = $this->user_repository->generate_user_token([
                'user_id' => $user->id, 
                'user_token_type_id' => $user_token_type_id, 
                'content' => $user_token_content, 
                'activated_time' => now(), 
                'expiration_time' => now()->addMinutes(10), 
                'created_at' => now(), 
                'updated_at' => now()
            ]);
        }
        
        $user_token = $this->user_repository->get_user_token($user->id, $user_token_type_id);

        if (empty($user_token)) {
            return [
                'code' => -1, 
                'message' => '查無此使用者驗證碼!'
            ];
        }

        Mail::to($email)->send(new UserForgetPasswordToken($user_token));

        return [
            'code' => 0, 
            'message' => '已寄發驗證碼至您的電子郵件!'
        ];
    }
    /**
     *  驗證使用者 token 是否有效
     * 
     *  @param string $email
     *  @param int $user_token_type_id
     *  @param string $content
     * 
     *  @return bool
     */
    public function verify_user_token(string $email, int $user_token_type_id, string $content)
    {
        $user = $this->user_repository->get_user_by_email($email);

        if (empty($user)) {
            return false;
        }

        if (!$this->user_repository->user_token_validate($user->id, $user_token_type_id, $content)) {
            return false;
        }

        return true;
    }
}