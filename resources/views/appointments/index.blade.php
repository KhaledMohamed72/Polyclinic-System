@extends('layouts.app')
@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <!-- fullCalendar -->
    <link rel="stylesheet" href="{{asset('assets/fullcalender/lib/main.css')}}">
    <script src="{{asset('assets/fullcalender/lib/main.js')}}"></script>
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    @include('appointments.calender')
    <style>
        .fc .fc-toolbar-title {
            font-size: smaller;
            margin-left: 5px;
        }

        .fc .fc-button-group {
            font-size: smaller;
        }
    </style>
@endsection
@section('title')   Appointments    @endsection
@section('header-title')    Appointments    @endsection
@section('header-title-one')    Appointments    @endsection
@section('header-title-two')    Calender   @endsection

@section('content')
    @php
        $hasRoleAdminNRecep = auth()->user()->hasRole(['admin','recep']);
        $hasRoleDoctor = auth()->user()->hasRole('doctor');
    @endphp
    @if(\Jenssegers\Agent\Facades\Agent::isMobile())
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-6 float-right">
                            <a href="{{route('appointments.create')}}" class="btn btn-block bg-gradient-success">Add
                                Appointment</a>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <div id="appointment_list">

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Patient</th>
                                    @if($hasRoleAdminNRecep)
                                        <th>doctor</th>
                                    @endif
                                    <th>Time</th>
                                    @if($hasRoleAdminNRecep)
                                        <th>doctor</th>
                                    @endif
                                    @if($hasRoleDoctor)
                                        <th>action</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody id="new_list">
                                @foreach($rows as $row)
                                    <tr>
                                        <td>{{$row->id}}</td>
                                        <td> {{$row->patient_name}}</td>
                                        @if($hasRoleAdminNRecep)
                                            <td>{{$row->doctor_name}}</td>
                                        @endif
                                        <td>{{date("g:i a", strtotime($row->time))}}</td>
                                        <td>
                                            @if($hasRoleDoctor)
                                                <a href="{{route('patients.show',$row->patient_id) . '?date='. $row->date . '&patient_id=' . $row->patient_id}}"
                                                   class="btn btn-primary btn-sm" title="Patient Profile"><i
                                                        class="fas fa-eye"></i></a>
                                            @endif
                                            @if($hasRoleDoctor && $row->status == 'pending')
                                                <a href="{{route('prescriptions.create') . '?date='. $row->date . '&patient_id=' . $row->patient_id}}"
                                                   class="btn btn-info btn-sm" title="create prescription"><i
                                                        class="fas fa-file"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div id="no_list"></div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.col -->
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-6 float-right">
                            <a href="{{route('appointments.create')}}" class="btn btn-block bg-gradient-success">Add
                                Appointment</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <h4 class="card-title mb-4">Appointment List | <label
                                id="selected_date">{{date("Y-m-d")}}</label>
                        </h4>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Patient</th>
                                @if($hasRoleAdminNRecep)
                                    <th>doctor</th>
                                @endif
                                <th>Time</th>
                                @if($hasRoleDoctor)
                                    <th>action</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody id="new_list">
                            <tr>
                            @foreach($rows as $row)
                                <tr>
                                    <td>{{$row->id}}</td>
                                    <td> {{$row->patient_name}} </td>
                                    @if($hasRoleAdminNRecep)
                                        <td>{{$row->doctor_name}}</td>
                                    @endif
                                    <td>{{date("g:i a", strtotime($row->time))}}</td>
                                    <td>
                                        @if($hasRoleDoctor)
                                            <a href="{{route('patients.show',$row->patient_id) . '?date='. $row->date . '&patient_id=' . $row->patient_id}}"
                                               class="btn btn-primary btn-sm" title="Patient Profile"><i
                                                    class="fas fa-eye"></i></a>
                                        @endif
                                        @if($hasRoleDoctor && $row->status == 'pending')
                                            <a href="{{route('prescriptions.create') . '?date='. $row->date . '&patient_id=' . $row->patient_id}}"
                                               class="btn btn-info btn-sm" title="create prescription"><i
                                                    class="fas fa-file"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                </tr>
                            </tbody>
                        </table>
                        <div id="no_list" class="text-center"></div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
    @endif
    <!-- /.row -->
@endsection
@section('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <!-- jQuery UI -->
    <script src="{{asset('assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- fullCalendar 2.2.5 -->
    <script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('assets/fullcalender/lib/main.js')}}"></script>

    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["csv", "excel", "pdf", "print", "colvis"], order: [[0, 'desc']],
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });

    </script>
@endsection
