@extends('layouts.app')
@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection
@section('title')   Incomes    @endsection
@section('header-title')    Incomes    @endsection
@section('header-title-one')    Incomes    @endsection
@section('header-title-two')    Main   @endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-2 float-right">
                        <a href="{{route('incomes.create')}}" class="btn btn-block bg-gradient-success">Add Income</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rows as $row)
                            @php
                                $doctor = \App\Models\user::where('id',$row->doctor_id)->first() ?? NULL ;
                            @endphp
                        <tr>
                            <td>{{$row->income_id}}</td>
                            <td>{{$row->type}}</td>
                            <td>{{$doctor->name ?? 'general'}}</td>
                            <td>{{$row->date}}</td>
                            <td>{{$row->amount}}</td>
                            <td class="project-actions text-left">
                                <a class="btn btn-primary btn-sm" href="{{route('incomes.show',$row->income_id)}}" title="View">
                                <i class="fas fa-eye">
                                </i>
                                </a>
                                <a class="btn btn-info btn-sm" href="{{route('incomes.edit',$row->income_id)}}" title="Edit">
                                <i class="fas fa-pencil-alt">
                                </i>
                                </a>
                                <form action="{{route('incomes.destroy',$row->income_id)}}" method="POST" style="display: contents;">
                                    {{ csrf_field() }}
                                    {{ method_field('delete') }}
                                <button type="submit" class="btn btn-danger btn-sm" href="#" title="Delete">
                                    <i class="fas fa-trash">
                                    </i>
                                </button>
                                </form>
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
    </script>
@endsection
