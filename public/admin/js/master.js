function logout_process()
{
    // 表單欄位資料
    var _token = document.querySelector('meta[name="csrf-token"]');
    var response, xhr = new XMLHttpRequest();
    xhr.open('POST', '/admin/logout_process');
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            response = JSON.parse(this.responseText);
            alert(response.message);
            if (response.code == 0) {
                location.reload();
            }
        }
    };
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-CSRF-TOKEN', _token.getAttribute('content'));
    xhr.send();
}