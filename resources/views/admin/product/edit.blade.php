@extends('admin.layouts.master')

@section('title', '修改產品')

@section('css')
<link rel="stylesheet" href="{{ asset('admin/css/product/edit.css') }}">
@endsection

@section('content')
<main class="m-3 p-3">
    <div class="container">
        <h4>修改產品</h4>

        <form id="edit-product-form">
            <table class="table table-striped">
                <tr>
                    <th>編號</th>
                    <td><a href="{{ route('admin.products.show', ['product' => $product]) }}">{{ $product->id }}</a></td>
                </tr>

                <tr>
                    <th>名稱</th>
                    <td>
                        <input type="text" name="name" id="name" value="{{ $product->name }}">
                    </td>
                </tr>

                <tr>
                    <th>價格</th>
                    <td>
                        <input type="number" name="price" id="price" value="{{ $product->price }}">
                    </td>
                </tr>

                <tr>
                    <th>描述</th>
                    <td>
                        <textarea name="description" id="description" rows="5">{{ $product->description }}</textarea>
                    </td>
                </tr>

                <tr>
                    <th>庫存量</th>
                    <td>
                        <input type="number" name="remaining_qty" id="remaining_qty" value="{{ $product->remaining_qty }}">
                    </td>
                </tr>

                <tr>
                    <th>製造日期</th>
                    <td>
                        <input type="date" name="manufacture_date" id="manufacture_date" value="{{ $product->manufacture_date }}">
                    </td>
                </tr>

                <tr>
                    <th>有效日期</th>
                    <td>
                        <input type="date" name="expiration_date" id="expiration_date" value="{{ $product->expiration_date }}">
                    </td>
                </tr>

                <tr>
                    <th>是否可販售</th>
                    <td>
                        <select name="is_sellable" id="is_sellable">
                            <option value="Y">是</option>
                            <option value="N">否</option>
                        </select>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</main>
@endsection