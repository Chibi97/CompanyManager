<header class="header-mobile header-mobile-2 d-block d-lg-none">
    <div class="header-mobile__bar">
        <div class="container-fluid">
            <div class="header-mobile-inner">
                <a class="logo" href="index.html">
                    <img src="images/icon/logo-white.png" alt="CoolAdmin"/>
                </a>
                <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                </button>
            </div>
        </div>
    </div>
    <nav class="navbar-mobile">
        <div class="container-fluid">
            <ul class="navbar-mobile__list list-unstyled">
                <li class="has-sub">
                    <a href="{{ route('job.offers') }}">
                        <i class="fas fa-home"></i>Dashboard</a>
                </li>

                @if(session()->has("user"))
                    @if(session()->get("user")->isBoss())
                        <li>
                            <a href="{{ route('company.dashboard') }}">
                                <i class="fas fa-lock-open"></i>Management Panel</a>
                        </li>
                    @endif

                    @if(session()->get("user")->isEmployee())
                        <li>
                            <a href="{{ route('employee.dashboard') }}">
                                <i class="fas fa-tasks"></i>Task Management</a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('logout') }}">
                            <i class="fas fa-sign-out-alt"></i>Logout</a>
                    </li>
                @else

                    <li>
                        <a href="{{ route('login.form') }}">
                            <i class="fas fa-sign-in-alt"></i>Login</a>
                    </li>
                    <li>
                        <a href="{{ route('register.form') }}">
                            <i class="fas fa-user-plus"></i>Register</a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</header>
