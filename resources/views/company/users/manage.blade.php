@extends('layouts.panel')

@section('content')
    <div class="section__content section__content--p30 manage-users">
        <div class="container-fluid">
            <div class="row">

                <div class="the-card col-12 col-md-6 col-lg-4">
                    <span class="user-status">Well done!</span>
                    <div class="au-card chart-percent-card">
                        <div class="au-card-inner">
                            <form action="" method="post">
                                @csrf

                                <div class="form-group">
                                    <label for="fname" class="control-label mb-1">First name</label>
                                    <input id="fname" name="first_name" type="text" class="form-control
                                            cc-exp" value="" >
                                </div>

                                <div class="form-group">
                                    <label for="lname" class="control-label mb-1">Last Name</label>
                                    <input id="lname" name="last_name" type="text" class="form-control
                                            cc-cvc" value="">
                                </div>

                                <div class="form-group">
                                    <label for="email" class="control-label mb-1">Email Address</label>
                                    <input id="email" name="email" type="email" class="form-control"
                                           value="">
                                </div>

                                <div class="form-group">
                                    <label for="pass" class="control-label mb-1">Password</label>
                                    <input id="pass" name="password" type="text" class="form-control"
                                           value="">
                                </div>

                                <div class="form-group">
                                    <label for="role" class="control-label mb-1">Role</label>
                                    <select name="role" id="role" class="form-control m-0">
                                        @foreach($roles as $id => $role)
                                            <option value="{{ $id }}">{{ $role }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <button id="payment-button" type="submit" class="btn btn-edit btn-md btn-block">
                                        <i class="far fa-edit m-r-10"></i> Update</span>
                                    </button>

                                    <button id="payment-button" type="submit" class="btn btn-arh btn-md btn-block">
                                        <i class="fas fa-user-times m-r-10"></i> Archive</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-6">
                    <meta name="api_token" content="{{ $token }}" />
                    <select data-selected="0" class="select-user" id="onChangeUser" name="users">
                        <option value="0">Select an employee</option>
                        @foreach($allUsers as $id => $user)
                            <option value="{{ $id }}"> {{ $user }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
@endsection