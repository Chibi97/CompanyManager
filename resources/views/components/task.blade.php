<div class="{{ $class ?? "col-md-6 col-xl-4 col-rewrite" }}">
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
                    {{ $slot }}
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
                        @if($task->count == 0)
                            <p class="info-color">This task, beside assigned ones, shouldn't
                                take any employee.</p>
                        @else
                            <p class="info-color">This task, beside assigned ones, should
                                take</p>
                            <p class="fw-500">
                                {{ $task->count .  " " . str_plural("employee", $task->count)  }}
                            </p>
                        @endif
                    </div>
                </li>
                <li class="list-group-item d-flex">
                    <div>
                        <i class="fas fa-highlighter pr-4"></i>
                    </div>
                    <div class="d-flex">
                        <p class="info-color mr-3 border-r-light">Priority</p>
                        <p class="fw-500">{{ $task->taskPriority->name }}</p>
                    </div>

                <li class="list-group-item d-flex">
                    <div>
                        <i class="fas fa-battery-half pr-4"></i>
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