<div class="row">
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-check-circle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">{{ trans('main_trans.total_appts') }} </span>
                <span class="info-box-number">
                  {{$appointments_count}}
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-calendar"></i></span>
            <a class="link-muted" href="{{route('today-appointment')}}">
            <div class="info-box-content">
                <span class="info-box-text">{{ trans('main_trans.todays_appointment') }} </span>
                <span class="info-box-number">{{$today_appointments_count}}</span>
            </div>
            </a>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <!-- fix for small devices only -->
    <div class="clearfix hidden-md-up"></div>
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">{{ trans('main_trans.todays_earning') }}</span>
                <span class="info-box-number">{{$today_earrings}}£</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-blue elevation-1"><i class="fas fa-calendar-plus"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">{{ trans('main_trans.tomorrow_appt') }}</span>
                <span class="info-box-number">{{$tomorrow_appointments_count}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-white elevation-1"><i class="fas fa-calendar-week"></i></span>
            <a class="link-muted" href="{{route('upcoming-appointment')}}">
            <div class="info-box-content">
                <span class="info-box-text">{{ trans('main_trans.upcoming_appt') }}</span>
                <span class="info-box-number">{{$upcomming_appointments_count}}</span>
            </div>
            </a>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money-bill"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">{{ trans('main_trans.revenue') }}</span>
                <span class="info-box-number">{{$revenue}}£</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>
