function store()
{
    // 預設不顯示錯誤訊息
    document.querySelectorAll('div[class$="-error"]').forEach(function (value, key) {
        document.querySelectorAll('div[class$="-error"]')[key].style.display = 'none';
    });
    // 表單欄位資料
    var _token = document.querySelector('meta[name="csrf-token"]');
    var name = document.getElementById('name');
    var price = document.getElementById('price');
    var description = document.getElementById('description');
    var remaining_qty = document.getElementById('remaining_qty');
    var manufacture_date = document.getElementById('manufacture_date');
    var expiration_date = document.getElementById('expiration_date');
    var is_sellable = document.getElementById('is_sellable');
    var response, xhr = new XMLHttpRequest();
    xhr.open('POST', '/admin/products');
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            response = JSON.parse(this.responseText);
            if ('errors' in response) {
                for (var attr in response.errors) {
                    if (response.errors[attr].length > 0) {
                        document.querySelector('.' + attr + '-error').style.display = 'block';
                        document.querySelector('.' + attr + '-error>div').textContent = response.errors[attr][0];
                    }
                }
            } else {
                alert(response.message);
                if (response.code == 0) {
                    location.reload();
                }
            }
        }
    };
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-CSRF-TOKEN', _token.getAttribute('content'));
    xhr.send('name=' + name.value + '&price=' + price.value + '&description=' + description.value + '&remaining_qty=' + remaining_qty.value + '&manufacture_date=' + manufacture_date.value + '&expiration_date=' + expiration_date.value + '&is_sellable=' + is_sellable.value);
}