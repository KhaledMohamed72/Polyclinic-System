@extends('layouts.app')
@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection
@section('title')   Income Profile    @endsection
@section('header-title')    Income Profile    @endsection
@section('header-title-one')    Incomes    @endsection
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
                  10
                </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-hourglass"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Pending Bills</span>
                            <span class="info-box-number">41,410</span>
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
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-cube"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Bill</span>
                            <span class="info-box-number">760</span>
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
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-content-below-appointment-tab" data-toggle="pill"
                                   href="#custom-content-below-appointment" role="tab"
                                   aria-controls="custom-content-below-appointment" aria-selected="true">
                                    <span><i class="fa fa-user"></i></span>&ensp;&ensp;
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-below-invoices-tab" data-toggle="pill"
                                   href="#custom-content-below-invoices" role="tab"
                                   aria-controls="custom-content-below-invoices" aria-selected="false">
                                    &ensp;&ensp;<span><i class="fa fa-pen-square"></i></span>&ensp;
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-content-below-appointment-tab" data-toggle="pill"
                                   href="#custom-content-below-appointment" role="tab"
                                   aria-controls="custom-content-below-appointment" aria-selected="true">
                                    &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;Appointment List&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-below-invoices-tab" data-toggle="pill"
                                   href="#custom-content-below-invoices" role="tab"
                                   aria-controls="custom-content-below-invoices" aria-selected="false">
                                    &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;Invoices&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
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
                                            <table id="example2" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Income Name</th>
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
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>test</td>
                                                    <td>01128206779</td>
                                                    <td>test@test.com</td>
                                                    <td>12-5-2022</td>
                                                    <td>09:00</td>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>test</td>
                                                    <td>01128206779</td>
                                                    <td>test@test.com</td>
                                                    <td>12-5-2022</td>
                                                    <td>09:00</td>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>test</td>
                                                    <td>01128206779</td>
                                                    <td>test@test.com</td>
                                                    <td>12-5-2022</td>
                                                    <td>09:00</td>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>test</td>
                                                    <td>01128206779</td>
                                                    <td>test@test.com</td>
                                                    <td>12-5-2022</td>
                                                    <td>09:00</td>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>test</td>
                                                    <td>01128206779</td>
                                                    <td>test@test.com</td>
                                                    <td>12-5-2022</td>
                                                    <td>09:00</td>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>test</td>
                                                    <td>01128206779</td>
                                                    <td>test@test.com</td>
                                                    <td>12-5-2022</td>
                                                    <td>09:00</td>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>test</td>
                                                    <td>01128206779</td>
                                                    <td>test@test.com</td>
                                                    <td>12-5-2022</td>
                                                    <td>09:00</td>
                                                </tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>test</td>
                                                    <td>01128206779</td>
                                                    <td>test@test.com</td>
                                                    <td>12-5-2022</td>
                                                    <td>09:00</td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                            </div>
                            {{-- End Appointment List table --}}
                        </div>
                        <div class="tab-pane fade" id="custom-content-below-invoices" role="tabpanel"
                             aria-labelledby="custom-content-below-invoices-tab">
                            {{-- invoices List table --}}
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <table id="example2" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Income Name</th>
                                                    <th>Phone</th>
                                                    <th>Email</th>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>action</th>
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
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
            }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    </script>
@endsection
