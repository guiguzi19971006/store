@extends('layouts.master')
@section('title', '首頁')
@section('content')
<style>
    
</style>

<main>
    <div class="main-content"></div>
    <div class="pagination"></div>
</main>

<script>
    // 顯示分頁內所有商品
    function showAllMerchandises(page = 1) {
        $.ajax({
            url: '/merchandise/index', 
            method: 'POST', 
            data: {
                page: page
            }, 
            dataType: 'JSON', 
            success: function(res) {
                var txt1 = '';
                var txt2 = '';
                if (res.status == 0) {
                    // 商品
                    for (var i in res.merchandises) {
                        txt1 += '<div class="content-box">';
                        txt1 += '<h2 class="merchandise-name">' + res.merchandises[i].name + '</h2>';
                        txt1 += '<a href="/merchandise/' + res.merchandises[i].id + '/show"><img src="images/' + res.merchandises[i].photo + '" class="merchandise-photo"></a>';
                        txt1 += '<div class="merchandise-price">NT$ <b>' + res.merchandises[i].price + '</b> 元</div>';
                        txt1 += '</div>';
                    }
                    // 頁碼
                    txt2 += '<a href="javascript:showAllMerchandises(\'1\');"><|</a>';
                    if (res.current_page == 1) {
                        txt2 += '<a href="javascript:showAllMerchandises(\'1\');"><</a>';
                    } else {
                        txt2 += '<a href="javascript:showAllMerchandises(\'' + (parseInt(res.current_page) - 1) + '\');"><</a>';
                    }

                    for (var i = 1; i <= res.total_page; i++) {
                        txt2 += '<a href="javascript:showAllMerchandises(\'' + i + '\');">' + i + '</a>';
                    }
                    
                    if (res.current_page == res.total_page) {
                        txt2 += '<a href="javascript:showAllMerchandises(\'' + res.current_page + '\');">></a>';
                    } else {
                        txt2 += '<a href="javascript:showAllMerchandises(\'' + (parseInt(res.current_page) + 1) + '\');">></a>';
                    }
                    txt2 += '<a href="javascript:showAllMerchandises(\'' + res.total_page + '\');">|></a>';
                    $('.main-content').html(txt1);
                    $('.pagination').html(txt2);
                }
            }
        });
    }
    showAllMerchandises();
</script>
@endsection