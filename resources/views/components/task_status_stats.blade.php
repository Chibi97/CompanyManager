
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