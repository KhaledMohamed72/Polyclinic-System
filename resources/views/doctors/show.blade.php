@extends('layouts.app')
@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection
@section('title')   Doctor Profile    @endsection
@section('header-title')    Doctor Profile    @endsection
@section('header-title-one')    Doctors    @endsection
@section('header-title-two')    Profile   @endsection

@section('content')
    <div class="row">
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
        <!-- /.col -->
        <div class="col-md-9">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-check-circle"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Appointments</span>
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
                        <div class="info-box-content">
                            <span class="info-box-text">Today's Appointments</span>
                            <span class="info-box-number">{{$today_appointments_count}}</span>
                        </div>
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
                            <span class="info-box-text">Today's Earning</span>
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
                            <span class="info-box-text">Tomorrow Appointments</span>
                            <span class="info-box-number">{{$tomorrow_appointments_count}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-white elevation-1"><i class="fas fa-calendar-week"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Upcomming Appointments</span>
                            <span class="info-box-number">{{$upcomming_appointments_count}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money-bill"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Revenue</span>
                            <span class="info-box-number">{{$revenue}}£</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                        @if(\Jenssegers\Agent\Facades\Agent::isMobile())
                        &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-content-below-appointment-tab" data-toggle="pill"
                               href="#custom-content-below-appointment" role="tab"
                               aria-controls="custom-content-below-appointment" aria-selected="true">
                                <span><i class="fa fa-user"></i></span>&ensp;&ensp;
                            </a>
                        </li>
                        &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
                        <li class="nav-item">
                            <a class="nav-link" id="custom-content-below-prescription-tab" data-toggle="pill"
                               href="#custom-content-below-prescription" role="tab"
                               aria-controls="custom-content-below-prescription" aria-selected="false">
                                &ensp;&ensp;<span><i class="fa fa-envelope"></i></span>&ensp;&ensp;
                            </a>
                        </li>
                        {{--                            <li class="nav-item">
                                                        <a class="nav-link" id="custom-content-below-invoices-tab" data-toggle="pill"
                                                           href="#custom-content-below-invoices" role="tab"
                                                           aria-controls="custom-content-below-invoices" aria-selected="false">
                                                            &ensp;&ensp;<span><i class="fa fa-pen-square"></i></span>&ensp;
                                                        </a>
                                                    </li>--}}
                        @else
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-content-below-appointment-tab" data-toggle="pill"
                                   href="#custom-content-below-appointment" role="tab"
                                   aria-controls="custom-content-below-appointment" aria-selected="true">
                                    &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;Today's Appointment&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-below-prescription-tab" data-toggle="pill"
                                   href="#custom-content-below-prescription" role="tab"
                                   aria-controls="custom-content-below-prescription" aria-selected="false">
                                    &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;Prescription List&ensp;&ensp;&ensp;&ensp;&ensp;
                                </a>
                            </li>
                            {{--                            <li class="nav-item">
                                                            <a class="nav-link" id="custom-content-below-invoices-tab" data-toggle="pill"
                                                               href="#custom-content-below-invoices" role="tab"
                                                               aria-controls="custom-content-below-invoices" aria-selected="false">
                                                                &ensp;&ensp;&ensp;&ensp;Invoices&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
                                                            </a>
                                                        </li>--}}
                        @endif
                    </ul>
                    <div class="tab-content" id="custom-content-below-tabContent">
                        <div class="tab-pane fade show active" id="custom-content-below-appointment" role="tabpanel"
                             aria-labelledby="custom-content-below-appointment-tab">
                            {{-- Appointment List table --}}
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <table id="" class="display table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Patient Name</th>
                                                    <th>Phone</th>
                                                    <th>Date</th>
                                                    <th>time</th>
                                                    <th>status</th>
                                                    <th>action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($appointments as $row)
                                                    <tr>
                                                        <td>{{$row->patient_id}}</td>
                                                        <td>{{$row->patient_name}}</td>
                                                        <td>{{$row->phone}}</td>
                                                        <td>{{$row->date}}</td>
                                                        <td>{{date("g:i A", strtotime($row->time))}}</td>
                                                        <td>
                                                            @if($row->status == 'pending')
                                                                <span class="badge badge-info">pending</span>
                                                            @elseif($row->status == 'cancel')
                                                                <span class="badge badge-danger">cancel</span>
                                                            @elseif($row->status == 'complete')
                                                                <span class="badge badge-primary">complete</span>
                                                            @else

                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-info btn-sm"
                                                               href="{{route('patients.show',$row->patient_id)}}"
                                                               title="Cancel">
                                                                <span><i class="fa fa-eye"></i></span>
                                                            </a>
                                                            @if($row->status == 'pending')
                                                                @if(auth()->user()->hasRole('doctor'))
                                                                    <a class="btn btn-primary btn-sm"
                                                                       href="{{route('prescriptions.create') . '?date='. $row->date . '&patient_id=' . $row->patient_id}}"
                                                                       title="Create Prescription">
                                                                        <span><i class="fas fa-file"></i></span>
                                                                    </a>
                                                                @endif

                                                                <a class="btn btn-danger btn-sm"
                                                                   href="{{route('cancel-action',$row->id)}}"
                                                                   title="Cancel">
                                                                    <span><i class="fa fa-sign-out-alt"></i></span>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                            </div>
                            {{-- End Appointment List table --}}
                        </div>
                        <div class="tab-pane fade" id="custom-content-below-prescription" role="tabpanel"
                             aria-labelledby="custom-content-below-prescription-tab">
                            {{-- prescription List table --}}
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <table id="" class="display table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Patient</th>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($prescriptions as $row)
                                                    <tr>
                                                        <td>{{$row->id}}</td>
                                                        <td>{{$row->patient_name}}</td>
                                                        <td>{{date('Y-m-d',strtotime($row->created_at))}}</td>
                                                        <td>{{date('h:i a',strtotime($row->created_at))}}</td>
                                                        <td class="project-actions text-left">
                                                            <a class="btn btn-primary btn-sm"
                                                               href="{{route('prescriptions.show',$row->id)}}"
                                                               title="View">
                                                                <i class="fas fa-eye">
                                                                </i>
                                                            </a>

                                                            @if(auth()->user()->hasRole('doctor'))
                                                                <a class="btn btn-info btn-sm"
                                                                   href="{{route('prescriptions.edit',$row->id)}}"
                                                                   title="Edit">
                                                                    <i class="fas fa-pencil-alt">
                                                                    </i>
                                                                </a>
                                                                <form
                                                                    action="{{route('prescriptions.destroy',$row->id)}}"
                                                                    method="POST"
                                                                    style="display: contents;">
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('delete') }}
                                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                                            href="#"
                                                                            title="Delete">
                                                                        <i class="fas fa-trash">
                                                                        </i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                            </div>
                            {{-- End Appointment List table --}}
                        </div>
                        {{--                        <div class="tab-pane fade" id="custom-content-below-invoices" role="tabpanel"
                                                     aria-labelledby="custom-content-below-invoices-tab">
                                                    --}}{{-- invoices List table --}}{{--
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="card">
                                                                <!-- /.card-header -->
                                                                <div class="card-body">
                                                                    <table id="example2" class="table table-bordered table-striped">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>Patient Name</th>
                                                                            <th>Phone</th>
                                                                            <th>Email</th>
                                                                            <th>Date</th>
                                                                            <th>time</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td>test</td>
                                                                            <td>01128206779</td>
                                                                            <td>test@test.com</td>
                                                                            <td>12-5-2022</td>
                                                                            <td>09:00</td>
                                                                            <td>
                                                                                <a class="btn btn-primary btn-sm" href="#" title="View">
                                                                                    <i class="fas fa-eye">
                                                                                    </i>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td>test</td>
                                                                            <td>01128206779</td>
                                                                            <td>test@test.com</td>
                                                                            <td>12-5-2022</td>
                                                                            <td>09:00</td>
                                                                            <td>
                                                                                <a class="btn btn-primary btn-sm" href="#" title="View">
                                                                                    <i class="fas fa-eye">
                                                                                    </i>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td>test</td>
                                                                            <td>01128206779</td>
                                                                            <td>test@test.com</td>
                                                                            <td>12-5-2022</td>
                                                                            <td>09:00</td>
                                                                            <td>
                                                                                <a class="btn btn-primary btn-sm" href="#" title="View">
                                                                                    <i class="fas fa-eye">
                                                                                    </i>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td>test</td>
                                                                            <td>01128206779</td>
                                                                            <td>test@test.com</td>
                                                                            <td>12-5-2022</td>
                                                                            <td>09:00</td>
                                                                            <td>
                                                                                <a class="btn btn-primary btn-sm" href="#" title="View">
                                                                                    <i class="fas fa-eye">
                                                                                    </i>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td>test</td>
                                                                            <td>01128206779</td>
                                                                            <td>test@test.com</td>
                                                                            <td>12-5-2022</td>
                                                                            <td>09:00</td>
                                                                            <td>
                                                                                <a class="btn btn-primary btn-sm" href="#" title="View">
                                                                                    <i class="fas fa-eye">
                                                                                    </i>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td>test</td>
                                                                            <td>01128206779</td>
                                                                            <td>test@test.com</td>
                                                                            <td>12-5-2022</td>
                                                                            <td>09:00</td>
                                                                            <td>
                                                                                <a class="btn btn-primary btn-sm" href="#" title="View">
                                                                                    <i class="fas fa-eye">
                                                                                    </i>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td>test</td>
                                                                            <td>01128206779</td>
                                                                            <td>test@test.com</td>
                                                                            <td>12-5-2022</td>
                                                                            <td>09:00</td>
                                                                            <td>
                                                                                <a class="btn btn-primary btn-sm" href="#" title="View">
                                                                                    <i class="fas fa-eye">
                                                                                    </i>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td>test</td>
                                                                            <td>01128206779</td>
                                                                            <td>test@test.com</td>
                                                                            <td>12-5-2022</td>
                                                                            <td>09:00</td>
                                                                            <td>
                                                                                <a class="btn btn-primary btn-sm" href="#" title="View">
                                                                                    <i class="fas fa-eye">
                                                                                    </i>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <!-- /.card-body -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    --}}{{-- End Appointment List table --}}{{--
                                                </div>--}}
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
@endsection
@section('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('table.display').DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                order: [[0, 'desc']]
            });
        });
    </script>
@endsection
