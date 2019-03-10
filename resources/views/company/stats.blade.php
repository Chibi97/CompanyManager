@extends('layouts.panel')

@section('content')
    <div class="main-content">
        <div class="dashboard-wrapper section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <form id="date-filters" action="{{route('company.dashboard')}}" method="GET" class="d-flex">
                                <div class="f-group">
                                    <label>Month: </label>
                                    <select data-selected="{{  $month  }}" class="select-change" name="month" id="SelectLm" class="form-control-sm form-control">
                                        @foreach($months as $i => $month)
                                            <option value="{{ $i + 1 }}"> {{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="f-group ml-4">
                                    <label>Year: </label>
                                    <select data-selected="{{ $year }}" class="select-change" name="year" id="SelectLm" class="form-control-sm form-control">
                                        @foreach($years as $year)
                                            <option> {{ $year }}</option>
                                        @endforeach

                                        @if(!$years)
                                            <option>{{ $year }}</option>
                                        @endif
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="row m-t-25 stats-container">
                    @foreach($stats as $label => $assoc)
                    <div class="stat-item col-sm-6 col-lg-3">
                        <div class="overview-item {{ $assoc['css']  }}">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="{{ $assoc['icon']  }}"></i>
                                    </div>
                                    <div class="text">
                                        <h2>{{  $assoc['count']  }}</h2>
                                        <span>tasks are <strong class="text-lowercase">{{ $label }}</strong></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
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

            </div>
        </div>
    </div>
@endsection
