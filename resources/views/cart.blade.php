@extends('layouts.master')
@section('title', '購物車清單')
@section('content')
<style>
    .content-box {
        width: 100%;
    }
    .cart-table {
        padding: 1rem;
        width: 100%;
        text-align: center;
    }
    .cart-table th {
        border: 1px solid #000;
    }
</style>

<main>
    <div class="main-content">
        <div class="content-box"></div>
    </div>
    <div class="pagination"></div>
</main>

<script>
    // 顯示購物車內所有商品
    function showAllCarts(page = 1) {
        $.ajax({
            url: '/cart/index', 
            method: 'POST', 
            data: {
                page: page
            }, 
            dataType: 'JSON', 
            success: function(res) {
                var txt1 = '';
                var txt2 = '';
                if (res.status == 0) {
                    // 購物車清單
                    txt1 += '<h2>購物車清單</h2>';
                    txt1 += '<table class="cart-table">';
                    txt1 += '<thead>';
                    txt1 += '<tr>';
                    txt1 += '<th>商品名稱</th><th>商品圖片</th><th>購買單價</th><th>購買數量</th><th>操作</th>';
                    txt1 += '</tr>';
                    if (res.cart_records.length == 0) {
                        txt1 += '<tr>';
                        txt1 += '<td colspan="5">暫無商品!</td>';
                        txt1 += '</tr>';
                    } else {
                        for (var i in res.cart_records) {
                            txt1 += '<tr>';
                            txt1 += '<td>' + res.cart_records[i].name + '</td>';
                            txt1 += '<td><img src="images/' + res.cart_records[i].photo + '" class="cart-merchandise-photo"></td>';
                            txt1 += '<td>' + res.cart_records[i].purchasing_unit_price + '</td>';
                            txt1 += '<td>' + res.cart_records[i].purchasing_qty + '</td>';
                            txt1 += '<td><a href="javascript:delCartItem(\'' + res.cart_records[i].id + '\');" class="btn">刪除</a></td>';
                            txt1 += '</tr>';
                        }
                    }
                    txt1 += '</thead>';
                    txt1 += '</table>';
                    // 頁碼
                    txt2 += '<a href="javascript:showAllCarts(\'1\');"><|</a>';
                    if (res.current_page == 1) {
                        txt2 += '<a href="javascript:showAllCarts(\'1\');"><</a>';
                    } else {
                        txt2 += '<a href="javascript:showAllCarts(\'' + (parseInt(res.current_page) - 1) + '\');"><</a>';
                    }

                    for (var i = 1; i <= res.total_page; i++) {
                        txt2 += '<a href="javascript:showAllCarts(\'' + i + '\');">' + i + '</a>';
                    }
                    
                    if (res.current_page == res.total_page) {
                        txt2 += '<a href="javascript:showAllCarts(\'' + res.current_page + '\');">></a>';
                    } else {
                        txt2 += '<a href="javascript:showAllCarts(\'' + (parseInt(res.current_page) + 1) + '\');">></a>';
                    }
                    txt2 += '<a href="javascript:showAllCarts(\'' + res.total_page + '\');">|></a>';
                    $('.content-box').html(txt1);
                    $('.pagination').html(txt2);
                }

                if (res.status == -1) {
                    alert(res.ret_val);
                    location.href = '/user/login';
                }
            }
        });
    }
    showAllCarts();
    // 刪除購物車單一商品
    function delCartItem(cart_id) {
        var confirmDelete = confirm('確定從購物車中刪除此商品?');
        if (confirmDelete) {
            $.ajax({
                url: '/cart/delete', 
                method: 'POST', 
                data: {
                    cart_id: cart_id
                }, 
                dataType: 'JSON', 
                success: function(res) {
                    alert(res.ret_val);
                    if (res.status == 0) {
                        showAllCarts();
                    }
                }
            });
        }
    }
</script>
@endsection