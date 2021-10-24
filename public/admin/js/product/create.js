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
    xhr.open('POST', '/admin/product');
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            response = JSON.parse(this.responseText);
            if ('errors' in response) {
                if ('name' in response.errors) {
                    if (response.errors.name.length > 0) {
                        document.querySelector('.name-error').style.display = 'block';
                        document.querySelector('.name-error>div').textContent = response.errors.name[0];
                    }
                }

                if ('price' in response.errors) {
                    if (response.errors.price.length > 0) {
                        document.querySelector('.price-error').style.display = 'block';
                        document.querySelector('.price-error>div').textContent = response.errors.price[0];
                    }                    
                }

                if ('description' in response.errors) {
                    if (response.errors.description.length > 0) {
                        document.querySelector('.description-error').style.display = 'block';
                        document.querySelector('.description-error>div').textContent = response.errors.description[0];
                    }                    
                }

                if ('remaining_qty' in response.errors) {
                    if (response.errors.remaining_qty.length > 0) {
                        document.querySelector('.remaining_qty-error').style.display = 'block';
                        document.querySelector('.remaining_qty-error>div').textContent = response.errors.remaining_qty[0];
                    }
                }

                if ('manufacture_date' in response.errors) {
                    if (response.errors.manufacture_date.length > 0) {
                        document.querySelector('.manufacture_date-error').style.display = 'block';
                        document.querySelector('.manufacture_date-error>div').textContent = response.errors.manufacture_date[0];
                    }
                }

                if ('expiration_date' in response.errors) {
                    if (response.errors.expiration_date.length > 0) {
                        document.querySelector('.expiration_date-error').style.display = 'block';
                        document.querySelector('.expiration_date-error>div').textContent = response.errors.expiration_date[0];
                    }
                }

                if ('is_sellable' in response.errors) {
                    if (response.errors.is_sellable.length > 0) {
                        document.querySelector('.is_sellable-error').style.display = 'block';
                        document.querySelector('.is_sellable-error>div').textContent = response.errors.is_sellable[0];
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