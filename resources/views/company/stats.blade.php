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
                                    <select data-selected="{{ $month }}" class="select-change" name="month"
                                            id="SelectLm" class="form-control-sm form-control">
                                        @foreach($months as $i => $month)
                                            <option value="{{ $i }}"> {{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="f-group ml-4">
                                    <label>Year: </label>
                                    <select data-selected="{{ $year }}" class="select-change" name="year" id="SelectLm"
                                            class="form-control-sm form-control">
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
            </div>
            @include('company.due_date_tasks')
        </div>
    </div>
@endsection
