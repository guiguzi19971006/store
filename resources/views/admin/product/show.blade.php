@extends('admin.layouts.master')

@section('title', '產品介紹')

@section('css')
<link rel="stylesheet" href="{{ asset('admin/css/product/show.css') }}">
@endsection

@section('content')
<main class="m-3 p-3 text-center">
    <div class="container">
        <h4>產品介紹</h4>

        <table class="table table-striped">
            <tr>
                <th>編號</th>
                <td>{{ $product->id }}</td>
            </tr>

            <tr>
                <th>名稱</th>
                <td>{{ $product->name }}</td>
            </tr>

            <tr>
                <th>價格</th>
                <td>{{ $product->price }}</td>
            </tr>

            <tr>
                <th>描述</th>
                <td>{{ $product->description }}</td>
            </tr>

            <tr>
                <th>庫存量</th>
                <td>{{ $product->remaining_qty }}</td>
            </tr>

            <tr>
                <th>製造日期</th>
                <td>{{ $product->manufacture_date }}</td>
            </tr>

            <tr>
                <th>有效日期</th>
                <td>{{ $product->expiration_date }}</td>
            </tr>

            <tr>
                <th>是否可販售</th>
                <td>{{ $product->is_sellable == 'N' ? '否' : '是' }}</td>
            </tr>

            <tr>
                <th>建立時間</th>
                <td>{{ $product->created_at }}</td>
            </tr>

            <tr>
                <th>最後更新時間</th>
                <td>{{ $product->updated_at }}</td>
            </tr>
        </table>

        <div class="row">
            <div class="col-6">
                <a href="{{ route('admin.products.index') }}" class="btn btn-success">回產品列表</a>
            </div>

            <div class="col-6">
                <a href="{{ route('admin.products.edit', ['product' => $product]) }}" class="btn btn-warning">修改產品</a>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')
<script src="{{ asset('admin/js/product/show.js') }}"></script>
@endsection