<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Company Manager</title>

    <link rel="stylesheet" href="{{ asset('css/bundle.css') }}">
</head>

<body class="animsition">
    <div class="page-wrapper">
        @include('inc.mobile-nav')

        @include('inc.sidebar')


        <!-- PAGE CONTAINER-->
        <div class="page-container">

            @include('inc.header')

            @yield('content')
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <script src="{{ asset('js/bundle.js') }}"></script>
</body>

</html>
