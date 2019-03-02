<!DOCTYPE html>
<html lang="en">

<head>
    @include('meta')
</head>

<body>
   {{-- class="animsition" --}}
    <div class="page-wrapper">
        @include('panel_inc.mobile_nav')

        @include('panel_inc.sidebar')

        <div class="page-container">

            @include('panel_inc.header')

            @yield('content')
        </div>

    </div>

    <script src="{{ asset('js/bundle.js') }}"></script>
</body>

</html>
