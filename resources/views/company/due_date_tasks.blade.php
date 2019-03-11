<div class="due-date-tasks">
    @if(!$dueDateTasks->isEmpty())
        <h3 class="h5">Due date tasks within <span class="info-color">10 days</span></h3>
        <div class="table-responsive table-responsive-data2">
        <table class="table table-data2">
            <thead>
            <tr>
                <th>task name</th>
                <th>assigned to</th>
                <th>date start</th>
                <th>status</th>
                <th>priority</th>
                <th>due date</th>
                <th>time left</th>
            </tr>
            </thead>
            <tbody>
                @foreach($dueDateTasks as $task)
                    <tr class="tr-shadow">
                        <td>
                            <span class="block-email">{{ $task->name}}</span>
                        </td>
                        <td class="desc">
                            <ul>
                                @foreach($task->users as $user)
                                    <li>{{ $user->first_name . " " . $user->last_name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td> {{ $task->start_date }}</td>
                        <td>
                            <span class="status--process">{{ $task->taskStatus->name }}</span>
                        </td>
                        <td>{{ $task->taskPriority->name }}</td>
                        <td> {{ $task->end_date }}</td>
                        <td class="danger">{{ $task->daysLeft }}</td>

                    </tr>
                    <tr class="spacer"></tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <h3 class="h5">There are no due date tasks within <span class="info-color">10 days</span></h3>
    @endif
</div>