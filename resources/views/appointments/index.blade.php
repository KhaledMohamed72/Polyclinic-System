@extends('layouts.app')
@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <!-- fullCalendar -->
    <link rel="stylesheet" href="{{asset('assets/fullcalender/lib/main.css')}}">
@endsection
@section('title')   Appointments    @endsection
@section('header-title')    Appointments    @endsection
@section('header-title-one')    Appointments    @endsection
@section('header-title-two')    Calender   @endsection

@section('content')
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
                    <div class="col-md-4 float-right">
                        <a href="{{route('patients.create')}}" class="btn btn-block bg-gradient-success">Add Appointment</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>doctor</th>
                            <th>Time</th>
                        </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>1</td>
                                <td> Hell Hell Hell</td>
                                <td>Kill Hell Hell</td>
                                <td>012:05 pm</td>
{{--                                <td class="project-actions text-left">
                                    <a class="btn btn-primary btn-sm" href="{{route('patients.show',$row->id)}}" title="View">
                                        <i class="fas fa-eye">
                                        </i>
                                    </a>
                                    <a class="btn btn-info btn-sm" href="{{route('patients.edit',$row->id)}}" title="Edit">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                    </a>
                                    <form action="{{route('patients.destroy',$row->id)}}" method="POST" style="display: contents;">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                        <button type="submit" class="btn btn-danger btn-sm" href="#" title="Delete">
                                            <i class="fas fa-trash">
                                            </i>
                                        </button>
                                    </form>--}}
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col -->
    </div>
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
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
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

        $(function () {

            /* initialize the calendar
             -----------------------------------------------------------------*/
            //Date for the calendar events (dummy data)
            var date = new Date()
            var d    = date.getDate(),
                m    = date.getMonth(),
                y    = date.getFullYear()

            var Calendar = FullCalendar.Calendar;
            var calendarEl = document.getElementById('calendar');

            // initialize the external events
            // -----------------------------------------------------------------

            var calendar = new Calendar(calendarEl, {
                now: '2022-10-24',
                scrollTime: '00:00', // undo default 6am scrollTime
                editable: false, // enable draggable events
                selectable: true,
                height:650,
                aspectRatio: 1.8,
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'timeGridWeek,dayGridMonth,listWeek'
                },

                initialView: 'dayGridMonth',

                events: [
                    { id: '1', resourceId: 'b', start: '2022-10-24T02:00:00', end: '2022-10-24T07:00:00', title: 'event 1' },
                    { id: '2', resourceId: 'c', start: '2020-09-07T05:00:00', end: '2020-09-07T22:00:00', title: 'event 2' },
                    { id: '3', resourceId: 'd', start: '2020-09-06', end: '2020-09-08', title: 'event 3' },
                    { id: '4', resourceId: 'e', start: '2020-09-07T03:00:00', end: '2020-09-07T08:00:00', title: 'event 4' },
                    { id: '5', resourceId: 'f', start: '2020-09-07T00:30:00', end: '2020-09-07T02:30:00', title: 'event 5' }
                ]
            });

            calendar.render();

        })
    </script>
@endsection
