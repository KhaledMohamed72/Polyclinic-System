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
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <!-- About Me Box -->
    <div class="card card-white">
        <div class="card-header mb-6">
            <h3 class="card-title">{{ trans('main_trans.personal_information') }}</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <strong><i class="fas fa-star mr-1"></i>{{ trans('main_trans.contactno') }}</strong>

            <p class="text-muted">
                {{$row->phone}}
            </p>

        </div>
        <!-- /.card-body -->
    </div>
    <div class="card card-white">
        <div class="card-header mb-6">
            <h3 class="card-title">{{ trans('main_trans.assign_doctor_information') }}</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <p class="text-muted text-center">
                <a href="{{route('doctors.show',$doctor->id)}}">
                    <span class="badge bg-primary">{{$doctor->name}}</span>
                </a>
            </p>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</div>
