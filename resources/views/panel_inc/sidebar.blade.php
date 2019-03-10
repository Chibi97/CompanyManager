<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="{{ route('job-offers') }}">
            <img src="{{ asset('images/icon/logo.png') }}" alt="Cool Admin" />
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li class="{{ Request::route()->named('employee.dashboard') ? 'active' : '' }} has-sub">
                    <a href="{{ route('employee.dashboard') }}">
                        <i class="fas fa-home"></i>Dashboard
                    </a>
                </li>
                <li class="{{ Request::route()->named('employee.my-tasks') ? 'active' : '' }}">
                    <a href="{{ route('employee.my-tasks') }}">
                        <i class="fas fa-thumbtack"></i>My Tasks
                    </a>
                </li>
                <li class="{{ Request::route()->named('employee.tasks') ? 'active' : '' }}">
                    <a href="{{ route('employee.tasks') }}">
                        <i class="fas fa-tasks"></i>Available Tasks
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>