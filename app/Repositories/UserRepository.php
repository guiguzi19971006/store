<?php

namespace App\Repositories;

use App\Models\User;
use DB;

class UserRepository
{
    public function get_user_by_email($email)
    {
        return User::where('email', $email)->first();
    }

    public function generate_user_tokens($data)
    {
        return DB::table('user_tokens')->insertGetId($data);
    }

    public function get_user_token_by_id($user_token_id)
    {
        return DB::table('user_tokens')->find($user_token_id);
    }

    public function user_token_exists($user_id, $user_token_type_id, $content)
    {
        $user_token = DB::table('user_tokens')
            ->where('user_id', $user_id)
            ->where('user_token_type_id', $user_token_type_id)
            ->where('content', $content)
            ->where('expiration_time', '>', now())
            ->first();
        
        return empty($user_token) ? false : true;
    }
}