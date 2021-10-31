function login()
{
    // 預設不顯示錯誤訊息
    document.querySelectorAll('div[class$="-error"]').forEach(function (value, key) {
        document.querySelectorAll('div[class$="-error"]')[key].style.display = 'none';
    });
    // 表單欄位資料
    var _token = document.querySelector('meta[name="csrf-token"]');
    var email = document.getElementById('email');
    var password = document.getElementById('password');
    var response, xhr = new XMLHttpRequest();
    xhr.open('POST', '/admin/login_process');
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            response = JSON.parse(this.responseText);
            if ('errors' in response) {
                for (var attr in response.errors) {
                    document.querySelector('.' + attr + '-error').style.display = 'block';
                    document.querySelector('.' + attr + '-error>div').textContent = response.errors[attr];
                }
            } else {
                if (response.code == 0) {
                    location.href = '/admin/index';
                }
            }
        }
    };
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-CSRF-TOKEN', _token.getAttribute('content'));
    xhr.send('email=' + email.value + '&password=' + password.value);
}