@extends('layouts.panel')

@section('content')
    <div class="section__content section__content--p30 manage-users">
        <div class="container-fluid">
            <div class="row update-wrapper">

                <div id="loading" class="the-card col-12 col-md-6 col-lg-6">
                    <div class="form-loading">
                        <div class="semipolar-spinner" :style="spinnerStyle">
                            <div class="ring"></div>
                            <div class="ring"></div>
                            <div class="ring"></div>
                            <div class="ring"></div>
                            <div class="ring"></div>
                        </div>
                    </div>
                    <span class="user-status">Status</span>
                    <div class="au-card chart-percent-card">
                        <div id="message-target" class="au-card-inner">
                            <form id="updateUserForm" data-page='users' action="" method="POST" name="updateUserForm">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">

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
                                    <input id="pass" name="password" type="password" class="form-control"
                                           value="" data-id="0">
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
                                    d-flex justify-content-center" data-id="0">
                                        <i class="far fa-edit m-r-10"></i> Update</span>
                                    </button>

                                </div>
                            </form>

                            <form method="POST" action="" id="archive-user">
                                <button type="button" class="btn btn-md btn-block danger-bg
                                d-flex justify-content-center" id="btnOpenModalUser" data-toggle="modal"
                                        data-target="#confirmDeleteModal" data-id="0">
                                    <i class="fas fa-user-times m-r-10"></i> Archive</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4 col-lg-4 user-select-wrapper">
                    <select data-selected="0" class="select-user prettySelect" id="onChangeUser" name="users">
                        <option value="0">Select an employee</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}"> {{ $user->first_name . ' ' . $user->last_name }} </option>
                        @endforeach
                    </select>

                    <div class="alert alert-warning m-l-15 w-100">
                        <p><strong>Warning:</strong> Archiving a user will delete all of his/hers tasks. Make sure
                            to detach users and attach other ones to these tasks.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let sessionUser = {!! json_encode($sessionUser) !!}
        document.querySelector('#onChangeUser').addEventListener('change', function() {
            var idSelect = this.value;
            if(idSelect == sessionUser) {
                console.log(sessionUser);
                document.querySelector('#role').disabled = true;
                document.querySelector('#btnOpenModalUser').disabled = true;
            } else {
                document.querySelector('#role').disabled = false;
                document.querySelector('#btnOpenModalUser').disabled = false;
            }
        })
    </script>
@endsection