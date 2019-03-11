<!DOCTYPE html>
<html lang="en">

<head>
    @include('meta')
</head>

<body>
    <div class="page-wrapper">
        @include('home_inc.header')
        @include('home_inc.header_mobile')
        @yield('content')
    </div>

    <script src="{{ asset('js/bundle.js') }}"></script>
</body>

</html>
