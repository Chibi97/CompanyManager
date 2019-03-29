
<header class="header-mobile d-block d-lg-none">
    <div class="header-mobile__bar">
        <div class="container-fluid">
            <div class="header-mobile-inner">
                <a class="logo" href="{{ route('job.offers') }}">
                    <img src="{{ asset('images/icon/logo.png') }}" alt="CoolAdmin" />
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
                @if(session()->get('user')->isEmployee())
                    <li>
                        <a href="{{ route('employee.dashboard') }}">
                            <i class="fas fa-home"></i>Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ route('employee.my-tasks') }}">
                            <i class="fas fa-thumbtack"></i>My Tasks</a>
                    </li>
                    {{--<li>--}}
                        {{--<a href="{{ route('employee.tasks') }}">--}}
                            {{--<i class="fas fa-tasks"></i>Available Tasks</a>--}}
                    {{--</li>--}}
                @elseif (session()->get('user')->isBoss())
                    <li class="{{ Request::route()->named('company.dashboard') ? 'active' : '' }} has-sub">
                        <a href="{{ route('company.dashboard') }}">
                            <i class="fas fa-home"></i>Dashboard
                        </a>
                    </li>

                    <li class="{{ Request::route()->named('users.index') ? 'active' : '' }} has-sub">
                        <a href="{{ route('users.index') }}">
                            <i class="fas fa-user-edit"></i>Manage employees
                        </a>
                    </li>

                    <li class="{{ Request::route()->named('tasks.index') ? 'active' : '' }} has-sub">
                        <a href="{{ route('tasks.index') }}">
                            <i class="fas fa-tasks"></i>Tasks
                        </a>
                    </li>

                    <li class="{{ Request::route()->named('tasks.create') ? 'active' : '' }} has-sub">
                        <a href="{{ route('tasks.create') }}">
                            <i class="fas fa-folder-plus"></i>Create a tasks
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</header>