@extends('layouts.app')
@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection
@section('title')   Patient Profile    @endsection
@section('header-title')    Patient Profile    @endsection
@section('header-title-one')    Patients    @endsection
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
                    <strong><i class="fas fa-star mr-1"></i> Contact No</strong>

                    <p class="text-muted">
                        {{$row->phone}}
                    </p>

                    <hr>

                    <strong><i class="fas fa-graduation-cap mr-1"></i> Email</strong>

                    <p class="text-muted">{{$row->email}}</p>

                </div>
                <!-- /.card-body -->
            </div>
            <div class="card card-white">
                <div class="card-header mb-6">
                    <h3 class="card-title">Assign Doctor Information</h3>
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
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-file"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Prescriptions</span>
                            <span class="info-box-number">{{$prescriptions_count}}</span>
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
                        <span class="info-box-icon material-icons bg-success">settings_accessibility</span>
                        <div class="info-box-content">
                            <span class="info-box-text">Sessions</span>
                            <span class="info-box-number">{{$sessions_count}}</span>
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
                     &ensp;&ensp;
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-content-below-appointment-tab" data-toggle="pill"
                               href="#custom-content-below-appointment" role="tab"
                               aria-controls="custom-content-below-appointment" aria-selected="true">
                                <span><i class="fa fa-user-plus"></i></span>&ensp;&ensp;
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="custom-content-below-prescription-tab" data-toggle="pill"
                               href="#custom-content-below-prescription" role="tab"
                               aria-controls="custom-content-below-prescription" aria-selected="false">
                                &ensp;&ensp;<span><i class="fa fa-file"></i></span>&ensp;&ensp;
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-content-below-sessions-tab" data-toggle="pill"
                               href="#custom-content-below-sessions" role="tab"
                               aria-controls="custom-content-below-sessions" aria-selected="false">
                                &ensp;&ensp;<span class="nav-icon material-icons">settings_accessibility</span>&ensp;
                            </a>
                        </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-content-below-appointment-tab" data-toggle="pill"
                                   href="#custom-content-below-appointment" role="tab"
                                   aria-controls="custom-content-below-appointment" aria-selected="true">
                                    &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;Appointment&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-below-prescription-tab" data-toggle="pill"
                                   href="#custom-content-below-prescription" role="tab"
                                   aria-controls="custom-content-below-prescription" aria-selected="false">
                                    &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;Prescription List&ensp;&ensp;&ensp;&ensp;&ensp;
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-below-sessions-tab" data-toggle="pill"
                                   href="#custom-content-below-sessions" role="tab"
                                   aria-controls="custom-content-below-sessions" aria-selected="false">
                                    &ensp;&ensp;&ensp;&ensp;Sessions&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
                                </a>
                            </li>
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
                                                        <td>{{$row->id}}</td>
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
                        <div class="tab-pane fade" id="custom-content-below-sessions" role="tabpanel"
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
                                                    @if(auth()->user()->hasRole(['admin', 'recep']))
                                                    <th>Doctor</th>
                                                    @endif
                                                    <th>Session type</th>
                                                    <th>Date</th>
                                                    <th>Fees</th>
                                                    @if(auth()->user()->hasRole('doctor'))
                                                    <th>action</th>
                                                    @endif
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($sessions as $row)
                                                    <tr>
                                                        <td>{{$row->id}}</td>
                                                        @if(auth()->user()->hasRole(['admin', 'recep']))
                                                            <td>{{$row->doctor_name}}</td>
                                                        @endif
                                                        <td>{{$row->session_name}}</td>
                                                        <td>{{date('Y-m-d',strtotime($row->created_at))}}</td>
                                                        <td>{{$row->fees}}</td>
                                                            @if(auth()->user()->hasRole('doctor'))
                                                            <td class="project-actions text-left">
                                                                <a class="btn btn-info btn-sm"
                                                                   href="{{route('sessions.edit',$row->id)}}"
                                                                   title="Edit">
                                                                    <i class="fas fa-pencil-alt">
                                                                    </i>
                                                                </a>
                                                                <form
                                                                    action="{{route('sessions.destroy',$row->id)}}"
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
