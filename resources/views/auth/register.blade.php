@extends('layouts.auth')

@section('form')
    <div class="login-form">
        <form action="" method="post">
            <div class="form-group">
                <label>Company Name</label>
                <input class="au-input au-input--full" type="text" name="company" placeholder="Company Name">
            </div>
            <div class="form-group">
                <label>Your First Name</label>
                <input class="au-input au-input--full" type="text" name="first-name" placeholder="First Name">
            </div>

            <div class="form-group">
                <label>Your Last Name</label>
                <input class="au-input au-input--full" type="text" name="first-name" placeholder="Last Name">
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input class="au-input au-input--full" type="email" name="email" placeholder="Email">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input class="au-input au-input--full" type="password" name="password" placeholder="Password">
            </div>
            <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign up</button>
        </form>
        <div class="register-link">
            <p>
                Already have an account?
                <a href="{{ route('login-form') }}">Sign In Here</a>
            </p>
        </div>
    </div>
@endsection