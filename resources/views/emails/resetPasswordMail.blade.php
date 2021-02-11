<p>
    親愛的 <b>{{ $name }}</b> 您好，請點選下方連結重新設定密碼:<br>
    <a href="{{ route('user.resetPassword', ['id' => $id, 'token' => $resetPasswordToken]) }}">{{ route('user.resetPassword', ['id' => $id, 'token' => $resetPasswordToken]) }}</a>
</p>