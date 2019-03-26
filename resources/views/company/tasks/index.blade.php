@extends('layouts.panel')

@section('content')
    <div class="section__content section__content--p30 company-tasks">
        <div class="container-fluid">
            <div class="d-flex justify-content-center mt-2 mb-5">
                <form action="{{route('tasks.index')}}" method="get" id="taskDateFilter" class="d-flex
                justify-content-center mt-2 mb-2">
                    <div class="f-group">
                        <label> Month: </label>
                        <select data-selected="{{ $month }}" class="prettySelect select-change" name="month"
                                id="SelectLm" class="form-control-sm form-control">
                            @foreach($months as $i => $month)
                                <option value="{{ $i }}"> {{ $month }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="f-group ml-4">
                        <label>Year: </label>
                        <select data-selected="{{ $year }}" class="prettySelect select-change" name="year"
                                class="form-control-sm form-control">
                            @foreach($years as $year)
                                <option>{{ $year }}</option>
                            @endforeach

                            @if(!$years)
                            <option>{{ $year }}</option>
                            @endif
                        </select>
                    </div>
                </form>
            </div>
            <div class="row tasks-container" data-page="tasks">
                @foreach($tasks as $task)
                    <div class="col-md-6 col-xl-4 col-rewrite">
                        <aside class="profile-nav alt">
                            <section class="card">
                                <div class="card-header user-header alt bg-dark">
                                    <div class="media">
                                        <div class="media-body">
                                            <h2 class="text-light display-6">
                                                {{ $task->name }}</h2>
                                        </div>
                                    </div>
                                </div>


                                <ul class="list-group list-group-flush">
                                    <li class="d-flex justify-content-around p-3">
                                        <a href="{{ route('tasks.edit', ['task' => $task->id]) }}" class="btn
                                        info-bg">
                                            <i class="far fa-edit m-r-10 text-white"></i>
                                            Update
                                        </a>

                                        <button type="button" class="btn danger-bg btnOpenModalArchiveTask"
                                                data-toggle="modal"
                                                data-target="#confirmDeleteModal"
                                                data-id="{{ $task->id }}">
                                            <i class="fas fa-user-times m-r-10 text-white"></i>
                                            Archive
                                        </button>
                                    </li>
                                    <li class="list-group-item d-flex">
                                        <div>
                                            <i class="fas fa-hourglass-start pr-4"></i>
                                        </div>

                                        <div class="d-flex">
                                            <p class="info-color border-r-light">Start date</p>
                                            <p class="fw-500">{{ $task->start_date }}</p>
                                        </div>

                                    </li>
                                    <li class="list-group-item d-flex">
                                        <div>
                                            <i class="fas fa-hourglass-end pr-4"></i>
                                        </div>
                                        <div class="d-flex">
                                            <p class="info-color mr-3 border-r-light">End date</p>
                                            <p class="fw-500">{{ $task->end_date }}</p>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex">
                                        <div>
                                            <i class="pr-4 icon-tally"></i>
                                        </div>
                                        <div>
                                            <p class="info-color">This task, beside assigned ones, should
                                            take</p>
                                            @if( $task->count == 1)
                                                <p class="fw-500">{{ $task->count . ' employee'}}</p>

                                            @else
                                                <p class="fw-500">{{ $task->count . ' employees' }}</p>
                                            @endif
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex">
                                        <div>
                                            <i class="fas fa-hourglass-end pr-4"></i>
                                        </div>
                                        <div class="d-flex">
                                            <p class="info-color mr-3 border-r-light">Priority</p>
                                            <p class="fw-500">{{ $task->taskPriority->name }}</p>
                                        </div>

                                    <li class="list-group-item d-flex">
                                        <div>
                                            <i class="fas fa-hourglass-end pr-4"></i>
                                        </div>
                                        <div class="d-flex">
                                            <p class="info-color mr-3 border-r-light">Status</p>
                                            <p class="fw-500">{{ $task->taskStatus->name }}</p>
                                        </div>

                                    </li>

                                    <li class="list-group-item d-flex">
                                        <p>
                                            <ul class="lst-none">
                                                @foreach($task->users as $user)
                                                    <li class="d-flex">
                                                        <i class="fas fa-user pr-4"></i>
                                                        <p class="fw-500">{{ $user->first_name . ' ' .
                                                        $user->last_name}}</p>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </p>
                                    </li>


                                    <li class="list-group-item d-flex">
                                        <div>
                                            <i class="fas fa-paragraph pr-4"></i>
                                        </div>
                                        <div>
                                            <p class="info-color">Description</p>
                                            <p class="fw-500">{{ $task->description }}</p>
                                        </div>
                                    </li>
                                </ul>

                            </section>
                        </aside>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection