@extends('admin.layouts.master')

@section('title', '線上購物後台管理系統 - 首頁')

@section('css')
<link rel="stylesheet" href="{{ asset('admin/css/product/index.css') }}">
@endsection

@section('content')
<main class="m-3 p-3 text-center">
    <div class="container">
        <h4>產品列表</h4>
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

        <div class="row">
            <div class="col-6">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">新增產品</a>
            </div>

            <div class="col-6">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#search-products-modal">
                    搜尋產品
                </button>
            </div>
        </div>
    </div>

    <div class="modal" id="search-products-modal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">搜尋產品</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('admin.products.search') }}" method="get" id="search-products-form">
                        <div class="row">
                            <div class="col-6">
                                關鍵字
                            </div>

                            <div class="col-6">
                                <input type="text" id="keyword" name="keyword">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3">
                                最低價格
                            </div>

                            <div class="col-3">
                                <input type="number" id="lowest-price" name="price[]">
                            </div>

                            <div class="col-3">
                                最高價格
                            </div>

                            <div class="col-3">
                                <input type="number" id="highest-price" name="price[]">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3">
                                最低庫存量
                            </div>

                            <div class="col-3">
                                <input type="number" id="lowest-remaining_qty" name="remaining_qty[]">
                            </div>

                            <div class="col-3">
                                最高庫存量
                            </div>

                            <div class="col-3">
                                <input type="number" id="highest-remaining_qty" name="remaining_qty[]">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3">
                                開始製造日期
                            </div>

                            <div class="col-3">
                                <input type="date" id="start-manufacture_date" name="manufacture_date[]">
                            </div>

                            <div class="col-3">
                                結束製造日期
                            </div>

                            <div class="col-3">
                                <input type="date" id="end-manufacture_date" name="manufacture_date[]">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3">
                                開始有效日期
                            </div>

                            <div class="col-3">
                                <input type="date" id="start-expiration_date" name="expiration_date[]">
                            </div>

                            <div class="col-3">
                                結束有效日期
                            </div>

                            <div class="col-3">
                                <input type="date" id="end-expiration_date" name="expiration_date[]">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                可否販售
                            </div>

                            <div class="col-6">
                                <select name="is_sellable" id="is_sellable">
                                    <option value="Y">是</option>
                                    <option value="N">否</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3">
                                最初建立時間
                            </div>

                            <div class="col-3">
                                <input type="datetime-local" id="first-created_at-time" name="created_at[]">
                            </div>

                            <div class="col-3">
                                最後建立時間
                            </div>

                            <div class="col-3">
                                <input type="datetime-local" id="last-created_at-time" name="created_at[]">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3">
                                最初更新時間
                            </div>

                            <div class="col-3">
                                <input type="datetime-local" id="first-updated_at-time" name="updated_at[]">
                            </div>

                            <div class="col-3">
                                最後更新時間
                            </div>

                            <div class="col-3">
                                <input type="datetime-local" id="last-updated_at-time" name="updated_at[]">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark">搜尋產品</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')
<script src="{{ asset('admin/js/product/index.js') }}"></script>
@endsection