@extends('layouts.master')
@section('title', '重設密碼')
@section('content')
<style>

</style>

<main>
    <div class="main-content">
        <div class="content-box">
            <h2>重設密碼</h2>

            <div class="form-input-box">
                <div class="input-label">
                    <span class="form-required-mark">*</span>新密碼
                </div>
                <div class="input-value">
                    <input type="password" id="password">
                </div>
            </div>

            <div class="form-input-box">
                <div class="input-label">
                    <span class="form-required-mark">*</span>確認密碼
                </div>
                <div class="input-value">
                    <input type="password" id="confirm-password">
                </div>
            </div>

            <div class="form-format">
                <table>
                    <tr>
                        <th>新密碼</th>
                        <td>長度介於 8 到 20 之英數字</td>
                    </tr>

                    <tr>
                        <th>確認密碼</th>
                        <td>與<b>新密碼</b>相同</td>
                    </tr>
                </table>
            </div>

            <a href="javascript:confirmResetPassword();" class="btn">重設密碼</a>
        </div>
    </div>
</main>

<script>
    function confirmResetPassword() {
        $.ajax({
            url: '/user/{{ $id }}/resetPasswordProcess/{{ $token }}', 
            method: 'POST', 
            data: {
                password: $('#password').val(), 
                confirm_password: $('#confirm-password').val()
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