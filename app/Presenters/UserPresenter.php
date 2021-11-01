<?php

namespace App\Presenters;

use Illuminate\Http\Request;

class UserPresenter
{
    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function user_login_greeting($user_type)
    {
        $greeting_text = '';
        if ($this->request->session()->has($user_type)) {
            $greeting_text .= '<span class="text-light m-3">' . $this->request->session()->get($user_type)['first_name'] . '，您好!</span>';
            $greeting_text .= '<a class="btn btn-primary" href="javascript: logout_process();">登出</a>';
        }
        
        return $greeting_text;
    }
}