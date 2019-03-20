@extends('layouts.panel')

@section('content')

    <div class="section__content section__content--p30 manage-users">
        <div class="container-fluid">
            <div class="row update-wrapper">
                <div class="the-card col-12 col-md-7 col-lg-7">
                    <div class="au-card chart-percent-card">
                        <form id="addNewTask" action="" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">

                            <div class="form-group">
                                <label for="tname" class="control-label mb-1">Name</label>
                                <input id="tname" data-id="0" name="name" type="text" class="form-control
                                        cc-exp" value="" >
                            </div>

                            <div class="form-group">
                                <label for="desc" class="control-label mb-1">Description</label>
                                <textarea id="desc" name="description" class="form-control"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="startDate" class="control-label mb-1">Start date</label>
                                <input id="startDate" name="start_date" type="datetime-local" class="form-control"
                                       value="{{ $defaultDate }}">
                            </div>

                            <div class="form-group">
                                <label for="endDate" class="control-label mb-1">End date</label>
                                <input id="endDate" name="end_date" type="datetime-local" class="form-control"
                                       value="{{ $defaultDate }}">
                            </div>

                            <div class="form-group">
                                <label for="count" class="control-label mb-1">Number of employees</label>
                                <input id="count" name="count" type="number" min="1" class="form-control" value="1">
                            </div>

                            <div class="form-group">
                                <label class="control-label mb-1">Assign employees to the task</label>
                                <select id="selectMultipleUsers" multiple style="width: 75%"
                                        name="employees[]">
                                    @foreach($employees as $id => $employee)
                                        <option value="{{ $id }}">{{ $employee }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="priority" class="control-label mb-1">Priority</label>
                                <select name="priority" id="priority" class="form-control ml-0">
                                    @foreach($priorities as $priority)
                                        <option>{{ $priority }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <button id="btn-add-task" type="submit" class="btn btn-edit btn-md btn-block
                                d-flex justify-content-center">
                                    <meta name="api_token" content="{{ $token }}" />
                                    <i class="fas fa-folder-plus m-r-10 mt-1"></i> Add</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
              <div class="col-12 col-md-4 col-lg-4">
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
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection