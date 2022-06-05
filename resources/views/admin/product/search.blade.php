@extends('admin.layouts.master')

@section('title', '線上購物後台管理系統 - 搜尋產品')

@section('css')
<link rel="stylesheet" href="{{ asset('admin/css/product/search.css') }}">
@endsection

@section('content')
<main class="m-3 p-3 text-center">
    <div class="container">
        <h4>產品搜尋結果</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>編號</th>
                    <th>名稱</th>
                    <th>價格</th>
                    <th>庫存量</th>
                    <th>製造日期</th>
                    <th>有效日期</th>
                    <th>可否販售</th>
                    <th>建立時間</th>
                    <th>更新時間</th>
                </tr>
            </thead>

            <tbody>
                @if ($products->isEmpty())
                <tr>
                    <td colspan="9">暫無產品!</td>
                </tr>
                @else
                    @foreach ($products as $product)
                    <tr>
                        <td><a href="{{ route('admin.products.show', ['product' => $product]) }}">{{ $product->id }}</a></td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->remaining_qty }}</td>
                        <td>{{ $product->manufacture_date }}</td>
                        <td>{{ $product->expiration_date }}</td>
                        <td>{{ $product->is_sellable == 'Y' ? '可' : '不可' }}</td>
                        <td>{{ $product->created_at }}</td>
                        <td>{{ $product->updated_at }}</td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        {{ $products->links() }}
    </div>
</main>
@endsection

@section('js')
<script src="{{ asset('admin/js/product/search.js') }}"></script>
@endsection