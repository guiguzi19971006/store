<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/css/master.css') }}">
    @yield('css')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    @inject('user_presenter', 'App\Presenters\UserPresenter')
    
    @include('admin.components.nav')

    @yield('content')

    @include('admin.components.footer')

    <script src="{{ asset('admin/js/master.js') }}"></script>
    <script>
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
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.setRequestHeader('Authorization', '{{ env("OAUTH_TOKEN_TYPE") . " " . env("OAUTH_ACCESS_TOKEN") }}');
            xhr.send();
        }
    </script>
    @yield('js')
</body>
</html>