@extends('layouts.master')
@section('title', '忘記密碼')
@section('content')
<style>

</style>

<main>
    <div class="main-content">
        <div class="content-box">
            <h2>忘記密碼</h2>

            <div class="form-input-box">
                <div class="input-label">
                    註冊時的電子郵件
                </div>
                <div class="input-value">
                    <input type="email" id="email">
                </div>
            </div>

            <a href="javascript:resetPassword();" class="btn">發送重設密碼連結信</a>
        </div>
    </div>
</main>

<script>
    function resetPassword() {
        $.ajax({
            url: '/user/forgetPasswordProcess', 
            method: 'POST', 
            data: {
                email: $('#email').val()
            }, 
            dataType: 'JSON', 
            success: function(res) {
                alert(res.ret_val);
                if (res.status == 0) {
                    location.href = '/user/login';
                }
            }
        });
    }
</script>
@endsection