@extends('admin.layouts.master')

@section('title', '線上購物後台管理系統 - 管理者登入')

@section('css')
<link rel="stylesheet" href="{{ asset('admin/css/login.css') }}">
@endsection

@section('content')
<main class="m-3 p-3 text-center">
    <div class="container p-3">
        <h4>管理者登入</h4>
        <form id="admin-login-form" class="m-3">
            <div class="mb-3 mt-3">
                <label for="email">電子郵件</label>
                <input type="email" class="form-control" name="email" id="email">
                <div class="email-error">
                    <div class="alert alert-danger"></div>
                </div>
            </div>

            <div class="mb-3 mt-3">
                <label for="password">密碼</label>
                <input type="password" class="form-control" name="password" id="password">
                <div class="password-error">
                    <div class="alert alert-danger"></div>
                </div>
            </div>

            <p>
                <a href="javascript: login();" class="btn btn-primary">登入</a>
            </p>
            <p>
                <a href="{{ route('admin.forget_password') }}">忘記密碼?</a>
            </p>
        </form>
    </div>
</main>

<script>
    function login()
    {
        // 預設不顯示錯誤訊息
        document.querySelectorAll('div[class$="-error"]').forEach(function (value, key) {
            document.querySelectorAll('div[class$="-error"]')[key].style.display = 'none';
        });
        // 表單欄位資料
        var _token = document.querySelector('meta[name="csrf-token"]');
        var email = document.getElementById('email');
        var password = document.getElementById('password');
        var response, xhr = new XMLHttpRequest();
        xhr.open('POST', '/admin/login_process');
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                response = JSON.parse(this.responseText);
                if ('errors' in response) {
                    for (var attr in response.errors) {
                        document.querySelector('.' + attr + '-error').style.display = 'block';
                        document.querySelector('.' + attr + '-error>div').textContent = response.errors[attr];
                    }
                } else {
                    if (response.code == 0) {
                        alert(response.message);
                        if ('referrer' in document) {
                            location.href = document.referrer;
                        } else {
                            location.href = '/admin/index';
                        }
                    }
                }
            }
        };
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-CSRF-TOKEN', _token.getAttribute('content'));
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('Authorization', '{{ env("OAUTH_TOKEN_TYPE") . " " . env("OAUTH_ACCESS_TOKEN") }}');
        xhr.send('email=' + email.value + '&password=' + password.value);
    }
</script>
@endsection

@section('js')
<script src="{{ asset('admin/js/login.js') }}"></script>
@endsection