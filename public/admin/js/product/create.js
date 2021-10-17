function store()
{
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
            alert(response.message);
        }
    };
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-CSRF-TOKEN', _token.getAttribute('content'));
    xhr.send('name=' + name.value + '&price=' + price.value + '&description=' + description.value + '&remaining_qty=' + remaining_qty.value + '&manufacture_date=' + manufacture_date.value + '&expiration_date=' + expiration_date.value + '&is_sellable=' + is_sellable.value);
}