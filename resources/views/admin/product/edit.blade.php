@extends('admin.layouts.master')

@section('title', '修改產品')

@section('css')
<link rel="stylesheet" href="{{ asset('admin/css/product/edit.css') }}">
@endsection

@section('content')
<main class="m-3 p-3 text-center">
    <div class="container">
        <h4>修改產品</h4>

        <form id="edit-product-form">
            <div class="input-group">
                <span class="input-group-text">
                    產品相片
                </span>

                <img src="{{ route('download', ['path' => ($base_path = base_path()) . (strpos($base_path, '/') === false ? str_replace('/', '\\', $photos->first()->path) : $photos->first()->path)]) }}" alt="{{ $product->name }}" width="50" height="50">
                <input type="file" class="form-control" name="photo" id="photo">
            </div>
            <div class="photo-error">
                <div class="alert alert-danger"></div>
            </div>

            <div class="input-group">
                <span class="input-group-text">
                    產品名稱
                </span>

                <input type="text" class="form-control" name="name" id="name" value="{{ $product->name }}">
            </div>
            <div class="name-error">
                <div class="alert alert-danger"></div>
            </div>

            <div class="input-group">
                <span class="input-group-text">
                    產品價格
                </span>

                <input type="number" class="form-control" name="price" id="price" value="{{ $product->price }}">
            </div>
            <div class="price-error">
                <div class="alert alert-danger"></div>
            </div>

            <div class="input-group">
                <span class="input-group-text">
                    產品描述
                </span>

                <textarea name="description" id="description" rows="5" class="form-control">{{ $product->description }}</textarea>
            </div>
            <div class="description-error">
                <div class="alert alert-danger"></div>
            </div>

            <div class="input-group">
                <span class="input-group-text">
                    產品庫存量
                </span>

                <input type="number" class="form-control" name="remaining_qty" id="remaining_qty" value="{{ $product->remaining_qty }}">
            </div>
            <div class="remaining_qty-error">
                <div class="alert alert-danger"></div>
            </div>

            <div class="input-group">
                <span class="input-group-text">
                    產品製造日期
                </span>

                <input type="date" class="form-control" name="manufacture_date" id="manufacture_date" value="{{ $product->manufacture_date }}">
            </div>
            <div class="manufacture_date-error">
                <div class="alert alert-danger"></div>
            </div>

            <div class="input-group">
                <span class="input-group-text">
                    產品有效日期
                </span>

                <input type="date" class="form-control" name="expiration_date" id="expiration_date" value="{{ $product->expiration_date }}">
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
                    <a href="{{ route('admin.products.show', ['product' => $product]) }}" class="btn btn-success">回產品介紹</a>
                </div>

                <div class="col-6">
                    <a href="javascript: update();" class="btn btn-dark">修改產品</a>
                </div>
            </div>
        </form>
    </div>
</main>

<script>
    function update()
    {
        // 預設不顯示錯誤訊息
        document.querySelectorAll('div[class$="-error"]').forEach(function (value, key) {
            document.querySelectorAll('div[class$="-error"]')[key].style.display = 'none';
        });
        // 表單欄位資料
        let edit_product_form = document.getElementById('edit-product-form');
        let _token = document.querySelector('meta[name="csrf-token"]');
        let response, form_data = new FormData(edit_product_form), xhr = new XMLHttpRequest();
        form_data.append('_method', 'PATCH');
        xhr.open('POST', '{{ route("admin.products.update", ["product" => $product]) }}');
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
<script src="{{ asset('admin/js/product/edit.js') }}"></script>
@endsection