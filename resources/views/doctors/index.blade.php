@extends('layouts.app')
@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection
@section('title')   {{ trans('main_trans.doctors') }}    @endsection
@section('header-title')    {{ trans('main_trans.doctors') }}    @endsection
@section('header-title-one')    {{ trans('main_trans.doctors') }}    @endsection
@section('header-title-two')    {{ trans('main_trans.main') }}   @endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-2 float-right">
                        @if(auth()->user()->hasRole('admin'))
                            @if(($clinicType == 0 && $doctors < 1) || $clinicType == 1)
                                <a href="{{route('doctors.create')}}" class="btn btn-block bg-gradient-success">{{ trans('main_trans.add_new_doctor') }}</a>
                            @endif
                        @endif
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>{{ trans('main_trans.id') }}</th>
                            <th>{{ trans('main_trans.title') }}</th>
                            <th>{{ trans('main_trans.name') }}</th>
                            <th>{{ trans('main_trans.contactno') }}</th>
                            <th>{{ trans('main_trans.email') }}</th>
                            <th>{{ trans('main_trans.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rows as $row)
                            <tr>
                                <td>{{$row->id}}</td>
                                <td>{{$row->title ?? 'No Title'}}</td>
                                <td>{{$row->name}}</td>
                                <td>{{$row->phone ?? 'No Contact'}}</td>
                                <td>{{$row->email}}</td>
                                <td class="project-actions text-left">
                                    <a class="btn btn-primary btn-sm" href="{{route('doctors.show',$row->id)}}"
                                       title="View">
                                        <i class="fas fa-eye">
                                        </i>
                                    </a>
                                    @if(auth()->user()->hasRole(['admin','recep']))
                                        <a class="btn btn-dark btn-sm" href="{{route('schedule-create',$row->id)}}"
                                           title="Doctor days and time availability">
                                            <i class="fas fa-calendar-alt">
                                            </i>
                                        </a>
                                    @endif
                                    @if(auth()->user()->hasRole('admin'))
                                        <a class="btn btn-info btn-sm" href="{{route('doctors.edit',$row->id)}}"
                                           title="Edit">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                        </a>
                                        @if(($clinicType == 1))
                                            <form action="{{route('doctors.destroy',$row->id)}}" method="POST"
                                                  style="display: contents;">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                                <button type="submit" class="btn btn-danger btn-sm" href="#"
                                                        title="Delete">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                </button>
                                            </form>
                                        @endif
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

    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["csv", "excel", "pdf", "print", "colvis"],order: [[0, 'desc']],
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
