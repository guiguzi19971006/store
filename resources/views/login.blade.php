@extends('layouts.master')
@section('title', '會員登入')
@section('content')
<style>
    #forgot-password-link, #register-link {
        color: #000;
    }
</style>

<main>
    <div class="main-content">
        <div class="content-box">
            <h2>會員登入</h2>

            <div class="form-input-box">
                <div class="input-label">
                    電子郵件
                </div>
                <div class="input-value">
                    <input type="email" id="email">
                </div>
            </div>

            <div class="form-input-box">
                <div class="input-label">
                    密碼
                </div>
                <div class="input-value">
                    <input type="password" id="password">
                </div>
            </div>

            <a href="javascript:userLogin();" class="btn">會員登入</a>

            <p>
                <a href="{{ route('user.forgetPassword') }}" id="forgot-password-link">忘記密碼</a>
                <span>或是</span>
                <a href="{{ route('user.register') }}" id="register-link">加入會員</a>
            </p>
        </div>
    </div>
</main>

<script>
    function userLogin() {
        $.ajax({
            url: '/user/loginProcess', 
            method: 'POST', 
            data: {
                email: $('#email').val(), 
                password: $('#password').val()
            }, 
            dataType: 'JSON', 
            success: function(res) {
                alert(res.ret_val);
                if (res.status == 0) {
                    location.href = '/';
                }
            }
        });
    }
</script>
@endsection