@extends('layouts.panel')

@section('content')
    <div class="section__content section__content--p30 company-tasks">
        <div class="container-fluid">
            <div class="d-flex justify-content-center mt-2 mb-5">
                <form action="{{route('tasks.index')}}" method="get" id="taskDateFilter" class="d-flex
                justify-content-center mt-2 mb-2">
                    @yearMonthFilter(['months' => $months,
                                              'years' => $years,
                                              'month' => $month,
                                              'year' => $year])
                    @endyearMonthFilter
                </form>
            </div>
            <div class="row tasks-container" data-page="tasks">
                @foreach($tasks as $task)
                    @task(['task' => $task ])
                    @endtask
                @endforeach
            </div>
        </div>
    </div>
@endsection