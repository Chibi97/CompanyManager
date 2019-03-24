@extends('layouts.panel')

@section('content')
    <div class="section__content section__content--p30 company-tasks">
        <div class="container-fluid">
            <div class="row">
                @foreach($tasks as $task)
                    <div class="col-md-4">
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
                                        <meta name="api_token" content="{{ $token }}" />
                                        <a href="{{ route('tasks.edit', ['task' => $task->id]) }}" class="btn
                                        info-bg">Update</a>

                                        <button type="button" class="btn danger-bg btnOpenModalArchiveTask" data-toggle="modal"
                                                data-target="#archiveTaskModal"
                                                data-id="{{ $task->id }}">
                                            Archive
                                        </button>
                                    </li>
                                    <li class="list-group-item">
                                        <p>
                                            <i class="fas fa-hourglass-start pr-4"></i> {{ $task->start_date }}
                                        </p>
                                    </li>
                                    <li class="list-group-item">
                                        <p>
                                            <i class="fas fa-hourglass-end pr-4"></i> {{ $task->end_date }}
                                        </p>
                                    </li>
                                    <li class="list-group-item">
                                        <p>
                                            <i class="pr-4 icon-tally"></i> {{ $task->count }}
                                        </p>
                                    </li>
                                    <li class="list-group-item">
                                        <p>
                                            <i class="fas fa-highlighter pr-4"></i> {{ $task->taskPriority->name }}
                                        </p>

                                    <li class="list-group-item">
                                        <p>
                                            <i class="far fa-check-square pr-4"></i> {{ $task->taskStatus->name }}
                                        </p>
                                    </li>
                                    <li class="list-group-item d-flex ">
                                        <p>
                                            <i class="fas fa-users pr-4"></i>
                                            <ul class="lst-none">
                                                @foreach($task->users as $user)
                                                    <li>
                                                        {{ $user->first_name }}</li>
                                                @endforeach
                                            </ul>
                                        </p>
                                    </li>


                                    <li class="list-group-item">
                                        <p>
                                            <i class="fas fa-paragraph pr-4"></i> {{ $task->description }}
                                        </p>
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