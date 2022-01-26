<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    /**
     *  透過電子郵件取得單一使用者資訊
     * 
     *  @param string $email
     * 
     *  @return mixed
     */
    public function get_user_by_email(string $email)
    {
        return User::where('email', $email)->first();
    }
    /**
     *  產生使用者 token
     * 
     *  @param array $data
     * 
     *  @return int
     */
    public function generate_user_token(array $data)
    {
        return DB::table('user_tokens')->insertGetId($data);
    }
    /**
     *  更新使用者 token
     * 
     *  @param int $user_id
     *  @param int $user_token_type_id
     *  @param array $data
     * 
     *  @return int
     */
    public function update_user_token(int $user_id, int $user_token_type_id, array $data)
    {
        return DB::table('user_tokens')
                    ->where('user_id', $user_id)
                    ->where('user_token_type_id', $user_token_type_id)
                    ->update($data);
    }
    /**
     *  取得單一使用者 token
     * 
     *  @param int $user_id
     *  @param int $user_token_type_id
     * 
     *  @return \Illuminate\Database\Eloquent\Model|object|static|null
     */
    public function get_user_token(int $user_id, int $user_token_type_id)
    {
        return DB::table('user_tokens')
                    ->where('user_id', $user_id)
                    ->where('user_token_type_id', $user_token_type_id)
                    ->first();
    }
    /**
     *  驗證使用者 token
     * 
     *  @param int $user_id
     *  @param int $user_token_type_id
     *  @param string $content
     * 
     *  @return bool
     */
    public function user_token_validate(int $user_id, int $user_token_type_id, string $content)
    {
        $user_token = DB::table('user_tokens')
                            ->where('user_id', $user_id)
                            ->where('user_token_type_id', $user_token_type_id)
                            ->where('content', $content)
                            ->where('expiration_time', '>', now())
                            ->first();
        
        return empty($user_token) ? false : true;
    }
    /**
     *  判斷使用者 token 是否存在
     * 
     *  @param int $user_id
     *  @param int $user_token_type_id
     * 
     *  @return bool
     */
    public function user_token_exists(int $user_id, int $user_token_type_id)
    {
        $user_token = DB::table('user_tokens')->where('user_id', $user_id)->where('user_token_type_id', $user_token_type_id)->first();
        return empty($user_token) ? false : true;
    }
}