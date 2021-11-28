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
@endsection

@section('js')
<script src="{{ asset('admin/js/forget_password.js') }}"></script>
@endsection