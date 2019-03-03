<div class="modal fade" id="loginModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Login</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="login-form">
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Email Address</label>
                            <input class="au-input au-input--full" type="email" name="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input class="au-input au-input--full" type="password" name="password" placeholder="Password">
                        </div>
                        <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign in</button>
                    </form>
                    <div class="register-link">
                        <p>
                            Don't you have account?
                            <a href="{{ route('register-form') }}">Sign Up Here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>