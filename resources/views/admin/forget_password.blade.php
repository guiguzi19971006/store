@extends('admin.layouts.master')

@section('title', '線上購物後台管理系統 - 忘記密碼')

@section('css')
<link rel="stylesheet" href="{{ asset('admin/css/forget_password.css') }}">
@endsection

@section('content')
<main class="m-3 p-3 text-center">
    <div class="container p-3">
        <h4>忘記密碼</h4>
        <form id="admin-login-form" class="m-3">
            <div class="mb-3 mt-3">
                <label for="email">電子郵件</label>
                <input type="email" class="form-control" name="email" id="email">
                <div class="email-error">
                    <div class="alert alert-danger"></div>
                </div>
            </div>

            <a href="javascript: generate_user_forget_password_token();" class="btn btn-primary">發送重設密碼連結</a>
        </form>
    </div>
</main>

<script>
    function generate_user_forget_password_token()
    {
        // 預設不顯示錯誤訊息
        document.querySelectorAll('div[class$="-error"]').forEach(function (value, key) {
            document.querySelectorAll('div[class$="-error"]')[key].style.display = 'none';
        });
        // 表單欄位資料
        var _token = document.querySelector('meta[name="csrf-token"]');
        var email = document.getElementById('email');
        var response, xhr = new XMLHttpRequest();
        xhr.open('POST', '/admin/generate_user_forget_password_token');
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
                        location.reload();
                    }
                }
            }
        };
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-CSRF-TOKEN', _token.getAttribute('content'));
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('Authorization', '{{ env("OAUTH_TOKEN_TYPE") . " " . env("OAUTH_ACCESS_TOKEN") }}');
        xhr.send('email=' + email.value);
    }
</script>
@endsection

@section('js')
<script src="{{ asset('admin/js/forget_password.js') }}"></script>
@endsection