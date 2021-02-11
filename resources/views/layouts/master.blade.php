<html lang="{{ app()->getLocale() }}">
<head>
    <title>線上購物系統 - @yield('title')</title>
    @include('partials.head')
</head>
<body>
    @include('partials.nav')
    @yield('content')
    @include('partials.footer')
</body>
</html>