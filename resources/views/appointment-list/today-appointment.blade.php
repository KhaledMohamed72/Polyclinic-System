@extends('layouts.app')
@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <!-- fullCalendar -->
    <link rel="stylesheet" href="{{asset('assets/plugins/fullcalendar/main.css')}}">
@endsection
@section('title')   Appointment List    @endsection
@section('header-title')    Appointment List    @endsection
@section('header-title-one')    Appointment List    @endsection
@section('header-title-two')    Main   @endsection
@php $roleAdminNRecep = auth()->user()->hasRole(['admin','recep']); @endphp
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <!-- Nav tabs -->
                @include('appointment-list.shared.appointment-header')
                <!-- Tab panes -->
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane active" role="tabpanel">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        @if($roleAdminNRecep)
                                            <th>Doctor</th>
                                        @endif
                                        <th>Patient</th>
                                        <th>Contact No</th>
                                        <th>Date</th>
                                        <th>time</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rows as $row)
                                        <tr>
                                            <td>{{$row->id}}</td>
                                            @if($roleAdminNRecep)
                                                <td>{{$row->doctor_name}}</td>
                                            @endif
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
                                                           title="Complete">
                                                            Create Prescription
                                                        </a>
                                                    @endif

                                                    <a class="btn btn-danger btn-sm"
                                                       href="{{route('cancel-action',$row->id)}}"
                                                       title="Complete">
                                                        Cancel
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    <script src="{{asset('assets/plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('assets/plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
    <!-- jQuery UI -->
    <script src="{{asset('assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

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
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection
