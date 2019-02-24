
@extends('layouts.platform')

@section('content')
<div class="main-content">
  <div class="section__content section__content--p30">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="overview-wrap">
            <ul class="user-stats">
              <li>
                Last logged in: <span>9:15 2/23/2019</span>
              </li>

              <li>
                Last logged out: <span>4:05 1/23/2019</span>
              </li>

              <li>
                Weekly works <span>20</span> hours.
              </li>
            </ul>

            <h2 class="user-status">Well done!</h2>
          </div>
        </div>

      </div>
      <div class="row m-t-25">
        <div class="col-sm-6 col-lg-3">
          <div class="overview-item overview-item--c1">
            <div class="overview__inner">
              <div class="overview-box clearfix">
                <div class="icon">
                  <i class="far fa-clock"></i>
                </div>
                <div class="text">
                  <h2>10</h2>
                  <span>tasks are currently in the making</span>
                </div>
              </div>
              <div class="overview-chart">
                <canvas id="widgetChart1"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="overview-item overview-item--c2">
            <div class="overview__inner">
              <div class="overview-box clearfix">
                <div class="icon">
                  <i class="far fa-check-square"></i>
                </div>
                <div class="text">
                  <h2>5</h2>
                  <span>tasks are done</span>
                </div>
              </div>
              <div class="overview-chart">
                <canvas id="widgetChart2"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="overview-item overview-item--c3">
            <div class="overview__inner">
              <div class="overview-box clearfix">
                <div class="icon">
                  <i class="fas fa-pause"></i>
                </div>
                <div class="text">
                  <h2>7</h2>
                  <span>tasks are on hold</span>
                </div>
              </div>
              <div class="overview-chart">
                <canvas id="widgetChart3"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="overview-item overview-item--c4">
            <div class="overview__inner">
              <div class="overview-box clearfix">
                <div class="icon">
                  <i class="fas fa-user-times"></i>
                </div>
                <div class="text">
                  <h2>3</h2>
                  <span>tasks are refused</span>
                </div>
              </div>
              <div class="overview-chart">
                <canvas id="widgetChart4"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
