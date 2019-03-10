<div class="due-date-tasks">
    <h2 class="shadow-font">Due date tasks</h2>
    <h2 class="over-shadow-font">Due date tasks</h2>
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
            @for($i = 1; $i <= 4; $i++)
                <tr class="tr-shadow">
                    <td>
                        <span class="block-email">Task #{{ $i }} about something</span>
                    </td>
                    <td class="desc">
                        <ul>
                            <li>Ryan Gosling</li>
                            {{--<li>Ryan Reynolds</li>--}}
                        </ul>
                    </td>
                    <td>2019-02-07 02:12</td>
                    <td>
                        <span class="status--process">In the making</span>
                    </td>
                    <td>HIGH</td>
                    <td class="danger">{{$i + 3}} days</td>

                </tr>
                <tr class="spacer"></tr>
            @endfor
            </tbody>
        </table>
    </div>
</div>