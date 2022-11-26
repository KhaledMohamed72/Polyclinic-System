@extends('layouts.pdf-app')
@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4 text-center">
                            <address>
                                <strong>Patient</strong>
                                <div>
                                    <strong> Name: </strong><span>{{$patient->name}}</span>
                                </div>
                                <div>
                                    <strong>  Date: </strong> <span>{{$prescription->date}}</span>
                                </div>
                                <div>
                                    <strong> Address: </strong><span>{{$patient->address}}</span>
                                </div>
                            </address>
                        </div>
                    </div>
                    @if(!$medicines->isEmpty())
                        <div class="row">
                            <div class="col-md-12">
                                <div class="py-2 mt-3">
                                    <h3 class="font-size-15 font-weight-bold">Medicines</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        @foreach($medicines as $row)
                                            <tr>
                                                <td>{{$row->medicine_name}}</td><d style="padding-left:3em;" > </d>
                                                <td>{{$row->frequency_name ?? ''}}</td><d style="padding-left:3em;" > </d>
                                                <td>{{$row->period_name ?? ''}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(!$tests->isEmpty())
                        <div class="row">
                            <div class="col-md-12">
                                <div class="py-2 mt-3">
                                    <h3 class="font-size-15 font-weight-bold">Test Reports</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        @foreach($tests as $row)
                                            <tr>
                                                <td>{{$row->name}}</td><d style="padding-left:3em;" > </d>
                                                <td>{{$row->note}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(!$formulas->isEmpty())
                        <div class="row">
                            <div class="col-md-12">
                                <div class="py-2 mt-3">
                                    <h3 class="font-size-15 font-weight-bold">Formulas</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        @foreach($formulas as $row)
                                            <tr>
                                                <td>{{$row->formula_name}}</td><d style="padding-left:3em;" > </d>
                                                <td>{{$row->frequency_name ?? ''}}</td><d style="padding-left:3em;" > </d>
                                                <td>{{$row->period_name ?? ''}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
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
    <script src="{{asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,order: [[0, 'desc']],
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
