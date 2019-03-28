
@extends('layouts.panel')

@section('content')
  <div class="employee-stats dashboard-wrapper section__content section__content--p30 company-tasks">
    <div class="container-fluid">
      <div class="row">
          <div class="col-md-9">
              <div class="overview-wrap justify-content-start">
                  <form id="employeeDateFilter" action="{{route('employee.dashboard')}}" method="GET" class="d-flex">
                      @yearMonthFilter(['months' => $months,
                                        'years' => $years,
                                        'month' => $month,
                                        'year' => $year])
                      @endyearMonthFilter
                  </form>
              </div>
          </div>

        <div class="col-md-3">
          <div class="overview-wrap justify-content-end">
            <h2 class="user-status">{{ $userStatus }}</h2>
          </div>
        </div>
      </div>

        <div class="row stats-container">
            @taskStatusStats(['stats' => $stats])
            @endtaskStatusStats
        </div>

        <h3 class="h4 mb-4 ml-1">Pending tasks</h3>

        <div class="row task-slider tasks-container">
            @foreach($pending as $task)
                @task(['task' => $task, 'class' => 'px-3'])
                <a href="#" id="acceptTask" class="btn info-bg" data-id="{{ $task->id }}">
                    <i class="fas fa-user-check text-white"></i>
                    Accept
                </a>

                <button type="button" class="btn danger-bg"
                        id="denyTasks"
                        data-id="{{ $task->id }}">
                    <i class="fas fa-user-times m-r-10 text-white"></i>
                    Deny
                </button>
                @endtask
            @endforeach
        </div>
    </div>
  </div>
@endsection
