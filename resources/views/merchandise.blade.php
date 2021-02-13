@extends('layouts.master')
@if (empty($merchandise))
    @section('title', '查無此商品')
@else
    @section('title', $merchandise->name . ' - 商品資訊')
@endif
@section('content')
<style>
    .put-to-cart-btn {
        text-decoration: none;
        color: #fff;
        background-color: #000;
        padding: 0.5rem;
        border-radius: 5px;
    }
</style>

<main>
    <div class="main-content">
        <div class="content-box">
            @if (empty($merchandise))
                <h2>查無此商品!</h2>
            @else
                <h2 class="merchandise-name">
                    {{ $merchandise->name }}
                </h2>
                <img src="{{ asset('images/' . $merchandise->photo) }}" alt="">
                <div class="merchandise-price">
                    NT$ <b>{{ $merchandise->price }}</b>
                </div>
                <div class="merchandise-description">
                    <p>{{ $merchandise->description }}</p>
                </div>
                <div class="put-to-cart">
                    <p>
                        <input type="number" id="purchasing-qty" placeholder="購買數量">
                    </p>
                    <a href="javascript:putToCart('{{ $merchandise->id }}');" class="put-to-cart-btn">放入購物車</a>
                </div>
            @endif
        </div>
    </div>
</main>
@if (!empty($merchandise))
    <script>
        // 新增使用者瀏覽紀錄
        function createBrowsingHistory(merchandise_id) {
            $.ajax({
                url: '/activity/store', 
                method: 'POST', 
                data: {
                    merchandise_id: merchandise_id
                }, 
                dataType: 'JSON', 
                success: function(res) {
                    
                }
            });
        }
        createBrowsingHistory('{{ $merchandise->id }}');
        // 將商品放入購物車
        function putToCart(merchandise_id) {
            $.ajax({
                url: '/cart/store', 
                method: 'POST', 
                data: {
                    merchandise_id: merchandise_id, 
                    qty: $('#purchasing-qty').val()
                }, 
                dataType: 'JSON', 
                success: function(res) {
                    alert(res.ret_val);
                    if (res.status == -1) {
                        location.href = '/user/login';
                    }
                }
            });
        }
    </script>
@endif
@endsection