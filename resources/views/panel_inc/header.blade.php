
<header class="header-desktop">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="header-wrap">
                <form class="form-header" action="" method="POST">
                    <input class="au-input au-input--xl" type="text" name="search" placeholder="Search for tasks" />
                    <button class="au-btn--submit" type="submit">
                        <i class="zmdi zmdi-search"></i>
                    </button>
                </form>
                <div class="header-button">
                    <div class="content">
                        <a href="{{ route('logout') }}" class="au-btn au-btn-icon au-btn--blue">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>