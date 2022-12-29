<div class="col-md-3">
    <!-- Profile Image -->
    <div class="card card-white card-outline">
        <div class="card-body box-profile">
            <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                     src="{{!empty($row->profile_photo_path) ? asset('images/users/'.$row->profile_photo_path) : asset('assets/dist/img/noimage.png')}}"
                     alt="User profile picture">
            </div>

            <h3 class="profile-username text-center">{{$row->name}}</h3>

            <p class="text-muted text-center">{{str_limit($row->degree,20)}}</p>

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <div class="card card-white">
        <div class="card-header mb-6">
            <h3 class="card-title font-weight-bold">Monthly Earning</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <div id="month_earring_rate"></div>
                </div>
                <div class="col-sm-12">
                    <p class="text-muted">This month</p>
                    <h3>{{$current_monthly_earrings}}£</h3>
                    <p class="text-muted">
                            <span class=" text-success  mr-2">
                                {{number_format($earring_percentage, 2, '.', '')}}% <i class="fa fa-arrow-up"></i>
                            </span>From previous month
                    </p>
                </div>

            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- About Me Box -->
    <div class="card card-white">
        <div class="card-header mb-6">
            <h3 class="card-title">Personal Information</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <strong><i class="fas fa-star mr-1"></i> Specialist</strong>

            <p class="text-muted">
                {{$row->specialist}}
            </p>

            <hr>

            <strong><i class="fas fa-graduation-cap mr-1"></i> Title</strong>

            <p class="text-muted">{{$row->title}}</p>

            <hr>

            <strong><i class="fas fa-pencil-alt mr-1"></i> Biography</strong>

            <p class="text-muted">
                {{str_limit(strip_tags($row->bio),100)}}
            </p>

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <div class="card card-white">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-calendar mr-1"></i>Available Days & Time</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @foreach($schedule_rows as $row)
                <strong>{{$row->day_of_week}}</strong>

                <p class="text-muted text-center">
                @if($row->second_start_time != '')
                    <p><span class="badge ml-3 bg-danger">1</span></p>
                @endif
                <p class="ml-5">
                    <span class="badge mr-3 bg-primary">From</span>
                    {{date("g:i A", strtotime($row->first_start_time))}}
                </p>
                </p>
                <p class="text-muted text-center">
                    <span class="badge ml-3 mr-3 bg-info">To</span>
                    {{date("g:i A", strtotime($row->first_end_time))}}
                </p>
                @if($row->second_start_time != '')
                    <p class="text-muted text-center">
                    <p><span class="badge ml-3 bg-danger">2</span></p>
                    <p class="ml-5">
                        <span class="badge mr-3 bg-primary">From</span>
                        {{date("g:i A", strtotime($row->second_start_time))}}
                    </p>
                    </p>
                    <p class="text-muted text-center">
                        <span class="badge ml-3 mr-3 bg-info">To</span>
                        {{date("g:i A", strtotime($row->second_end_time))}}
                    </p>
                @endif
            @endforeach
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
