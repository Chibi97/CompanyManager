@extends('layouts.panel')

@section('content')
    <div class="section__content section__content--p30 manage-users">
        <div class="container-fluid">
            <div class="row update-wrapper">

                <div class="the-card col-12 col-md-6 col-lg-6">
                    <span class="user-status">Status</span>
                    <div class="au-card chart-percent-card">
                        <div id="message-target" class="au-card-inner">
                            @if ($errors->any() )
                                <div class="alert alert-warning">
                                    @foreach ($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif

                            @if(session()->has('success'))
                                <div class="alert alert-success">
                                     <p>{{ session()->get('success') }}</p>
                                </div>
                            @endif
                            <form id="updateUserForm" action="" method="POST" name="updateUserForm">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">

                                <div class="form-group">
                                    <label for="fname" class="control-label mb-1">First name</label>
                                    <input id="fname" data-id="0" name="first_name" type="text" class="form-control
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
                                    <input id="pass" name="password" type="password" class="form-control"
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
                                    <button id="btn-update-user" type="submit" class="btn info-bg btn-md btn-block
                                    d-flex justify-content-center">
                                        <i class="far fa-edit m-r-10"></i> Update</span>
                                    </button>

                                </div>
                            </form>

                            <form method="POST" action="" id="archive-user">
                                <button id="btn-archive-user" type="submit"
                                        class="btn btn-md btn-block danger-bg d-flex justify-content-center">
                                    <i class="fas fa-user-times m-r-10"></i> Archive</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4 col-lg-4 user-select-wrapper">
                    <meta name="api_token" content="{{ $token }}" />
                    <select data-selected="0" class="select-user prettySelect" id="onChangeUser" name="users">
                        <option value="0">Select an employee</option>
                        @foreach($fullNames as $id => $user)
                            <option value="{{ $id }}"> {{ $user }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
@endsection