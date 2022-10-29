@extends('layouts.app')
@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection
@section('title')   PRESCRIPTION DETAILS    @endsection
@section('header-title')    PRESCRIPTION DETAILS    @endsection
@section('header-title-one')    PRESCRIPTIONS     @endsection
@section('header-title-two')    PRESCRIPTION DETAILS   @endsection

@section('content')
    <div class="row d-print-none">
        <div class="col-12">
            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light mb-4">
                <i class="fa fa-print"></i>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice-title">
                        <h4 class="float-right font-size-16">Prescription #1</h4>
                        <div class="mb-4">
                            <img src="{{asset('assets/dist/img/pulpo-logo.jpg')}}" alt="logo"
                                 height="50"/>
                            <strong>PULPO CLINIC</strong>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-5">
                            <address>
                                <strong>Dr</strong>
                                <br>Sayed Ahmed<br>
                                <i class="fas fa-sm fa-phone-alt"></i> 01128206779<br>
                                <i class="fas fa-sm fa-envelope"></i> doctor@clinic.com<br>
                            </address>
                        </div>
                        <div class="col-4">
                            <address>
                                <strong>Patient</strong>
                                <br>Khaled Ahmed<br>
                                <i class="fas fa-sm fa-phone-alt"></i> 01128206779<br>
                            </address>
                        </div>
                        <div class="col-3">
                            <address>
                                <strong>Prescription Date: </strong>2022-10-30 02:05<br>
                                <strong>Appointment Date: </strong>2022-10-30 12:30<br>
                            </address>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5 mt-3 text-center">
                            <address>
                                <strong>Symptoms:</strong><br>
                                Dolore itaque quis i
                                Aut aperiam aliquambr <br>
                                Aut aperiam aliquambr <br>
                                Aut aperiam aliquambr
                            </address>
                        </div>
                        <div class="col-5 mt-3 text-center">
                            <address>
                                <strong>Diagnosis:</strong><br>
                                Aut aperiam aliquambr <br>
                                Aut aperiam aliquambr <br>
                                Aut aperiam aliquambr

                            </address>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="py-2 mt-3">
                                <h3 class="font-size-15 font-weight-bold">Medications</h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th style="width: 70px;">No.</th>
                                        <th>Name</th>
                                        <th>Notes</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Anim officiis volupt</td>
                                        <td>Nesciunt quam eos i</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Velit consequatur q</td>
                                        <td>Aut mollit quam obca</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Sed sint dolor inci</td>
                                        <td>Omnis fugiat modi sa</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="py-2 mt-3">
                                <h3 class="font-size-15 font-weight-bold">Test Reports</h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th style="width: 70px;">No.</th>
                                        <th>Name</th>
                                        <th>Notes</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td> Incididunt perspicia</td>
                                        <td> Sit natus deserunt</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td> Necessitatibus eos i</td>
                                        <td> Corporis sit iusto t</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td> Quis doloribus solut</td>
                                        <td> Aliquip blanditiis l</td>
                                    </tr>
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
