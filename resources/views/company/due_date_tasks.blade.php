<div class="due-date-tasks">

    <h3 class="title-5">Due date tasks</h3>
    <div class="table-responsive table-responsive-data2">
        <table class="table table-data2">
            <thead>
            <tr>
                <th>task name</th>
                <th>assigned to</th>
                <th>date start</th>
                <th>status</th>
                <th>priority</th>
                <th>time left</th>
            </tr>
            </thead>
            <tbody>
            @foreach($dueDateTasks as $i => $task)
                <tr class="tr-shadow">
                    <td>
                        <span class="block-email">{{ $task->name }}</span>
                    </td>
                    <td class="desc">
                        <ul>
                            <li>Ryan Gosling</li>
                            {{--<li>Ryan Reynolds</li>--}}
                        </ul>
                    </td>
                    <td>{{ $task->start_date }}</td>
                    <td>
                        <span class="status--process">In the making</span>
                    </td>
                    <td>HIGH</td>
                    <td class="danger">{{ $i }} days</td>

                </tr>
                <tr class="spacer"></tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>