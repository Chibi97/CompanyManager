<header class="header-desktop3 d-none d-lg-block">
    <div class="section__content section__content--p35">
        <div class="header3-wrap">
            <div class="header__logo">
                <a href="#">
                    <img src="images/icon/logo-white.png" alt="CoolAdmin"/>
                </a>
            </div>
            <div class="header__navbar">
                <ul class="list-unstyled">
                    <li>
                        <a href="{{ route('job.offers') }}">
                            <i class="fas fa-home"></i>Dashboard
                            <span class="bot-line"></span>
                        </a>
                    </li>

                    @if(session()->has("user"))
                        @if(session()->get("user")->isBoss())
                            <li>
                                <a href="{{ route('company.dashboard') }}">
                                    <i class="fas fa-lock-open"></i>Management panel
                                    <span class="bot-line"></span>
                                </a>
                            </li>
                        @endif

                        @if(session()->get("user")->isEmployee())
                            <li>
                                <a href="{{ route('employee.dashboard') }}">
                                    <i class="fas fa-tasks"></i>Task Management
                                    <span class="bot-line"></span>
                                </a>
                            </li>
                        @endif

                        <li>
                            <a href="{{ route('logout') }}">
                                <i class="fas fa-sign-out-alt"></i>Logout
                                <span class="bot-line"></span>
                            </a>
                        </li>

                    @else
                        <li>
                            <a href="{{ route('login.form') }}">
                                <i class="fas fa-sign-in-alt"></i>Login
                                <span class="bot-line"></span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('register.form') }}">
                                <i class="fas fa-user-plus"></i>Register
                                <span class="bot-line"></span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</header>
