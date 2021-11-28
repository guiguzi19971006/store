<div>
    您好，請點選以下連結重設密碼:
    <p>
        <a href="{{ route('admin.reset_password', ['token' => $token_content]) }}">
            {{ route('admin.reset_password', ['token' => $token_content]) }}
        </a>
    </p>
    <p>
        <b>
            提醒您，因重設密碼驗證碼有效時間為 10 分鐘，故務必於 10 分鐘內完成密碼重設動作，再次謝謝您使用本系統，祝您購物愉快，謝謝!
        </b>
    </p>
</div>