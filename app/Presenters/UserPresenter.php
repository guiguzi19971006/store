<?php

namespace App\Presenters;

use Illuminate\Http\Request;

class UserPresenter
{
    /**
     *  @var \Illuminate\Http\Request
     */
    public $request;
    /**
     *  建立 \Illuminate\Http\Request 實體
     * 
     *  @param \Illuminate\Http\Request $request
     * 
     *  @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     *  使用者有登入時需顯示的文字
     * 
     *  @param string $user_type
     * 
     *  @return string
     */
    public function user_login_greeting(string $user_type)
    {
        $greeting_text = '';

        if ($this->request->session()->has($user_type)) {
            $greeting_text .= '<span class="text-light m-3">' . $this->request->session()->get($user_type)['first_name'] . '，您好!</span>';
            $greeting_text .= '<a class="btn btn-primary" href="javascript: logout_process();">登出</a>';
        }
        
        return $greeting_text;
    }
}