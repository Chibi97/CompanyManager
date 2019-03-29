
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

        @if($pending->isEmpty())
            <h3 class="h4 mb-4 ml-1">There are no pending tasks</h3>
        @else
            <h3 class="h4 mb-4 ml-1">Pending tasks</h3>
        @endif

        <?php
            $ids = $pending->pluck('id');
        ?>
        <div data-tasks="{{ json_encode($ids) }}" class="row task-slider tasks-container">

            @foreach($pending as $task)
                @task(['task' => $task, 'class' => 'px-3'])
                <a href="#" class="acceptTask btn info-bg" data-id="{{ $task->id }}">
                    <i class="fas fa-user-check text-white"></i>
                    Accept
                </a>

                <a href="#" class="denyTask btn danger-bg"
                        data-id="{{ $task->id }}">
                    <i class="fas fa-user-times m-r-10 text-white"></i>
                    Deny
                </a>
                @endtask
            @endforeach
        </div>
    </div>
  </div>
@endsection
