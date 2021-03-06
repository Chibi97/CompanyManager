<!DOCTYPE html>
<html lang="en">

<head>
    @include('meta')
</head>

<body>
    <div class="page-wrapper">
        @include('panel_inc.mobile_nav')

        @include('panel_inc.sidebar')

        <div class="page-container">

            @include('panel_inc.header')

            <div class="main-content">
                @yield('content')

            </div>
        </div>

    </div>

    @include('modals');
    <script src="{{ asset('js/bundle.js') }}"></script>
    <script src="{{asset('js/app.js')}}"></script>
</body>

</html>
