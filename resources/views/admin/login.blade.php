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

            <a href="javascript: login();" class="btn btn-primary">登入</a>
        </form>
    </div>
</main>
@endsection

@section('js')
<script src="{{ asset('admin/js/login.js') }}"></script>
@endsection