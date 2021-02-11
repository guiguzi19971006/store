@extends('layouts.master')
@section('title', '會員註冊')
@section('content')
<style>

</style>

<main>
    <div class="main-content">
        <div class="content-box">
            <h2>會員註冊</h2>

            <div class="form-input-box">
                <div class="input-label">
                    <span class="form-required-mark">*</span>真實姓名
                </div>
                <div class="input-value">
                    <input type="text" id="name">
                </div>
            </div>

            <div class="form-input-box">
                <div class="input-label">
                    <span class="form-required-mark">*</span>電子郵件
                </div>
                <div class="input-value">
                    <input type="email" id="email">
                </div>
            </div>

            <div class="form-input-box">
                <div class="input-label">
                    <span class="form-required-mark">*</span>自訂密碼
                </div>
                <div class="input-value">
                    <input type="password" id="password">
                </div>
            </div>

            <div class="form-input-box">
                <div class="input-label">
                    <span class="form-required-mark">*</span>手機號碼
                </div>
                <div class="input-value">
                    <input type="text" id="phone">
                </div>
            </div>

            <div class="form-input-box">
                <div class="input-label">
                    <span class="form-required-mark">*</span>現居住地
                </div>
                <div class="input-value">
                    <input type="text" id="address">
                </div>
            </div>

            <div class="form-input-box">
                <div class="input-label">
                    <span class="form-required-mark">*</span>年齡
                </div>
                <div class="input-value">
                    <input type="number" id="age">
                </div>
            </div>

            <div class="form-input-box">
                <div class="input-label">
                    <span class="form-required-mark">*</span>性別
                </div>
                <div class="input-value">
                    <select id="gender">
                        <option value="Male">男</option>
                        <option value="Female">女</option>
                    </select>
                </div>
            </div>

            <div class="form-format">
                <table>
                    <tr>
                        <th>
                            真實姓名
                        </th>
                        <td>
                            長度小於等於 30 字
                        </td>
                    </tr>

                    <tr>
                        <th>
                            電子郵件
                        </th>
                        <td>
                            長度小於等於 50 字
                        </td>
                    </tr>

                    <tr>
                        <th>
                            自訂密碼
                        </th>
                        <td>
                            長度介於 8 到 20 之英數字
                        </td>
                    </tr>

                    <tr>
                        <th>
                            手機號碼
                        </th>
                        <td>
                            長度小於等於 20 之數字
                        </td>
                    </tr>

                    <tr>
                        <th>
                            現居住地
                        </th>
                        <td>
                            長度小於等於 100 字
                        </td>
                    </tr>

                    <tr>
                        <th>
                            年齡
                        </th>
                        <td>
                            正整數
                        </td>
                    </tr>

                    <tr>
                        <th>
                            性別
                        </th>
                        <td>
                            下拉式選單: 男、女
                        </td>
                    </tr>
                </table>
            </div>

            <a href="javascript:userRegister();" class="btn">註冊</a>
        </div>
    </div>
</main>

<script>
    // 會員註冊
    function userRegister() {
        // 預設表單格式正確
        $('input').css('border-color', '#000');

        $.ajax({
            url: '/user/registerProcess', 
            method: 'POST', 
            data: {
                name: $("#name").val(), 
                email: $('#email').val(), 
                password: $('#password').val(), 
                phone: $('#phone').val(), 
                address: $('#address').val(), 
                age: $('#age').val(), 
                gender: $('#gender').val()
            }, 
            dataType: 'JSON', 
            success: function(res) {
                if (res.status == 0) {
                    alert(res.ret_val);
                    location.href = '/user/login';
                } else {
                    alert(res.ret_val);
                    for (var i in res.error_format_css_selector) {
                        $(res.error_format_css_selector[i]).css('border-color', 'red');
                    }
                }
            }
        });
    }
</script>
@endsection