@extends('layouts.panel')

@section('content')
    <div class="section__content section__content--p30 company-tasks">
            <div class="row tasks-container" data-page="tasks">
                @foreach($tasks as $task)
                    @task(['task' => $task ])
                        <select
                            id="SelectLm" class="form-control-sm form-control prettySelect task-status-change"
                                data-task="{{$task->id}}">
                                @foreach($statuses as $status)
                                    @if($status !=  $task->taskStatus->name )
                                        <option> {{$status}} </option>
                                    @else
                                    <option selected>{{ $task->taskStatus->name}}</option>
                                @endif
                                @endforeach
                        </select>
                    @endtask
                @endforeach
            </div>
        </div>
    </div>
@endsection
















