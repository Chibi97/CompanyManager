@extends('layouts.panel')

@section('content')
    <div class="dashboard-wrapper section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">
                    <div class="overview-wrap">
                        <form id="date-filters" action="{{route('company.dashboard')}}" method="GET" class="d-flex">
                            @yearMonthFilter(['months' => $months,
                                              'years' => $years,
                                              'month' => $month,
                                              'year' => $year])
                            @endyearMonthFilter
                        </form>
                    </div>
                </div>

            </div>
            <div class="row m-t-25 stats-container">
                @taskStatusStats(['stats' => $stats])
                @endtaskStatusStats
            </div>
            @include('company.due_date_tasks')
        </div>
    </div>
@endsection
