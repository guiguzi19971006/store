@extends('admin.layouts.master')

@section('title', '線上購物後台管理系統 - 新增產品')

@section('css')
<link rel="stylesheet" href="{{ asset('admin/css/product/create.css') }}">
@endsection

@section('content')
<main class="m-3 p-3 text-center">
    <div class="container">
        <h4>新增產品</h4>
        <form id="create-product-form">
            <div class="input-group">
                <span class="input-group-text">
                    產品相片
                </span>

                <input type="file" class="form-control" name="photo" id="photo">
            </div>
            <div class="photo-error">
                <div class="alert alert-danger"></div>
            </div>

            <div class="input-group">
                <span class="input-group-text">
                    產品名稱
                </span>

                <input type="text" class="form-control" name="name" id="name">
            </div>
            <div class="name-error">
                <div class="alert alert-danger"></div>
            </div>

            <div class="input-group">
                <span class="input-group-text">
                    產品價格
                </span>

                <input type="number" class="form-control" name="price" id="price">
            </div>
            <div class="price-error">
                <div class="alert alert-danger"></div>
            </div>

            <div class="input-group">
                <span class="input-group-text">
                    產品描述
                </span>

                <textarea name="description" id="description" rows="5" class="form-control"></textarea>
            </div>
            <div class="description-error">
                <div class="alert alert-danger"></div>
            </div>

            <div class="input-group">
                <span class="input-group-text">
                    產品庫存量
                </span>

                <input type="number" class="form-control" name="remaining_qty" id="remaining_qty">
            </div>
            <div class="remaining_qty-error">
                <div class="alert alert-danger"></div>
            </div>

            <div class="input-group">
                <span class="input-group-text">
                    產品製造日期
                </span>

                <input type="date" class="form-control" name="manufacture_date" id="manufacture_date">
            </div>
            <div class="manufacture_date-error">
                <div class="alert alert-danger"></div>
            </div>

            <div class="input-group">
                <span class="input-group-text">
                    產品有效日期
                </span>

                <input type="date" class="form-control" name="expiration_date" id="expiration_date">
            </div>
            <div class="expiration_date-error">
                <div class="alert alert-danger"></div>
            </div>

            <div class="input-group">
                <span class="input-group-text">
                    是否可販售
                </span>

                <select name="is_sellable" id="is_sellable" class="form-select">
                    <option value="Y">是</option>
                    <option value="N">否</option>
                </select>
            </div>
            <div class="is_sellable-error">
                <div class="alert alert-danger"></div>
            </div>

            <div class="row">
                <div class="col-6">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-success">回產品列表</a>
                </div>

                <div class="col-6">
                    <a href="javascript: store();" class="btn btn-dark">新增產品</a>
                </div>
            </div>
        </form>
    </div>
</main>

<script>
    function store()
    {
        // 預設不顯示錯誤訊息
        document.querySelectorAll('div[class$="-error"]').forEach(function (value, key) {
            document.querySelectorAll('div[class$="-error"]')[key].style.display = 'none';
        });
        // 表單欄位資料
        let create_product_form = document.getElementById('create-product-form');
        let _token = document.querySelector('meta[name="csrf-token"]');
        let photo = document.getElementById('photo');
        let name = document.getElementById('name');
        let price = document.getElementById('price');
        let description = document.getElementById('description');
        let remaining_qty = document.getElementById('remaining_qty');
        let manufacture_date = document.getElementById('manufacture_date');
        let expiration_date = document.getElementById('expiration_date');
        let is_sellable = document.getElementById('is_sellable');
        let response, form_data = new FormData(create_product_form), xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route("admin.products.store") }}');
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                response = JSON.parse(this.responseText);
                if ('errors' in response) {
                    for (let attr in response.errors) {
                        if (response.errors[attr].length > 0) {
                            document.querySelector('.' + attr + '-error').style.display = 'block';
                            document.querySelector('.' + attr + '-error>div').textContent = response.errors[attr][0];
                        }
                    }
                } else {
                    alert(response.message);
                    if (response.code == 0) {
                        location.reload();
                    }
                }
            }
        };
        xhr.setRequestHeader('X-CSRF-TOKEN', _token.getAttribute('content'));
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('Authorization', '{{ env("OAUTH_TOKEN_TYPE") . " " . env("OAUTH_ACCESS_TOKEN") }}');
        xhr.send(form_data);
    }
</script>
@endsection

@section('js')
<script src="{{ asset('admin/js/product/create.js') }}"></script>
@endsection