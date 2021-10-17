@extends('admin.layouts.master')

@section('title', '線上購物後台管理系統 - 新增產品')

@section('css')
<link rel="stylesheet" href="{{ asset('admin/css/product/create.css') }}">
@endsection

@section('content')
<main class="m-3 p-3 text-center">
    <div class="container">
        <form action="{{ route('admin.product.store') }}" method="post" id="create-product-form">
            @csrf
            <div class="input-group">
                <span class="input-group-text">
                    產品名稱
                </span>

                <input type="text" class="form-control" name="name" id="name">
            </div>

            <div class="input-group">
                <span class="input-group-text">
                    產品價格
                </span>

                <input type="number" class="form-control" name="price" id="price">
            </div>

            <label for="description">產品描述</label>
            <textarea name="description" id="description" rows="5" class="form-control"></textarea>

            <div class="input-group">
                <span class="input-group-text">
                    產品庫存量
                </span>

                <input type="number" class="form-control" name="remaining_qty" id="remaining_qty">
            </div>

            <div class="input-group">
                <span class="input-group-text">
                    產品製造日期
                </span>

                <input type="date" class="form-control" name="manufacture_date" id="manufacture_date">
            </div>

            <div class="input-group">
                <span class="input-group-text">
                    產品有效日期
                </span>

                <input type="date" class="form-control" name="expiration_date" id="expiration_date">
            </div>

            <label for="is_sellable" class="form-label">是否可販售</label>
            <select name="is_sellable" id="is_sellable" class="form-select">
                <option value="Y">是</option>
                <option value="N">否</option>
            </select>

            <a href="javascript: store();" class="btn btn-dark">新增產品</a>
        </form>
    </div>
</main>
@endsection

@section('js')
<script src="{{ asset('admin/js/product/create.js') }}"></script>
@endsection