@extends('admin.layouts.master')

@section('title', '產品介紹')

@section('css')
<link rel="stylesheet" href="{{ asset('admin/css/product/show.css') }}">
@endsection

@section('content')
<main class="m-3 p-3">
    <div class="container">
        <h4>產品介紹</h4>

        <table class="table table-striped">
            <tr>
                <th>編號</th>
                <td>{{ $product->id }}</td>
            </tr>

            <tr>
                <th>相片</th>
                <td>
                    @foreach ($photos as $photo)
                    <img src="{{ route('download', ['path' => $photo->path]) }}" alt="{{ $product->name }}" width="50" height="50">
                    @endforeach
                </td>
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
            <div class="col-4">
                <a href="{{ route('admin.products.index') }}" class="btn btn-success">回產品列表</a>
            </div>

            <div class="col-4">
                <a href="{{ route('admin.products.edit', ['product' => $product]) }}" class="btn btn-warning">修改產品</a>
            </div>

            <div class="col-4">
                <a href="javascript: destroy();" class="btn btn-danger">刪除產品</a>
            </div>
        </div>
    </div>
</main>

<script>
    function destroy()
    {
        if (confirm('確定刪除此產品?')) {
            var _token = document.querySelector('meta[name="csrf-token"]');
            var response, xhr = new XMLHttpRequest();
            xhr.open('DELETE', '{{ route("admin.products.destroy", ["product" => $product]) }}');
            xhr.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    response = JSON.parse(this.responseText);
                    alert(response.message);
                    if (response.code == 0) {
                        location.href = '{{ route("admin.products.index") }}';
                    }
                }
            };
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.setRequestHeader('X-CSRF-TOKEN', _token.getAttribute('content'));
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.setRequestHeader('Authorization', '{{ env("OAUTH_TOKEN_TYPE") . " " . env("OAUTH_ACCESS_TOKEN") }}');
            xhr.send();
        }
    }
</script>
@endsection

@section('js')
<script src="{{ asset('admin/js/product/show.js') }}"></script>
@endsection