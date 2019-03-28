
@extends('layouts.panel')

@section('content')
  <div class="dashboard-wrapper section__content section__content--p30 company-tasks">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="overview-wrap">
            <ul class="user-stats">
              <li>
                Last logged in: <span>9:15 2/23/2019</span>
              </li>

              <li>
                Last logged out: <span>4:05 1/23/2019</span>
              </li>
            </ul>

            <h2 class="user-status">Well done!</h2>
          </div>
        </div>

        <div class="col-md-12">
          <div class="overview-wrap">
            <form id="employeeDateFilter" action="{{route('employee.dashboard')}}" method="GET" class="d-flex">
              @yearMonthFilter(['months' => $months,
                                'years' => $years,
                                'month' => $month,
                                'year' => $year])
              @endyearMonthFilter
            </form>
          </div>
        </div>

        <div class="row m-t-25 stats-container">

          @taskStatusStats(['stats' => $stats])
          @endtaskStatusStats
        </div>

        <div class="row pending-tasks tasks-container">
          @foreach($pending as $task)
            @task(['task' => $task ])
            @endtask
          @endforeach
        </div>
      </div>
    </div>
  </div>
@endsection
