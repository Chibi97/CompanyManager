@extends('layouts.auth')

@section('form')
    <div class="login-form">
        @errors(['errors' => $errors])
        @enderrors

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Email Address</label>
                <input class="au-input au-input--full" type="email" name="email" placeholder="Email" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input class="au-input au-input--full" type="password" name="password" placeholder="Password">
            </div>
            <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign in</button>
        </form>
        <div class="register-link">
            <p>
                You don't have an account?
                <a href="{{ route('register.form') }}">Sign Up Here</a>
            </p>
        </div>
    </div>
@endsection