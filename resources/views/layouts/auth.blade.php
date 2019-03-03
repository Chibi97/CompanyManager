<!DOCTYPE html>
<html lang="en">

<head>
    @include('meta')
</head>

<body>
<div class="page-wrapper">
    <div class="page-content--bge5">
        <div class="container">
            <div class="login-wrap">
                <div class="login-content">
                    <div class="login-logo">
                        <a href="#">
                            <img src="images/icon/logo.png" alt="CoolAdmin">
                        </a>
                    </div>
                    @yield('form')
                </div>
            </div>
        </div>
    </div>

</div>

<script src="{{ asset('js/bundle.js') }}"></script>

</body>

</html>