@php
    $user = auth()->user();
    if($user->hasRole('admin')){
        $profile_route = '#';
    }
    if($user->hasRole('doctor')){
        $profile_route = route('doctors.show', auth()->user()->id);
    }
    if($user->hasRole('recep')){
        $profile_route = route('receptionists.show', auth()->user()->id);
    }
@endphp
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link">
        <img src="{{asset('assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Pulpo Clinic</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img
                    src="{{!empty($user->profile_photo_path) ? asset('images/users/'.$user->profile_photo_path) : asset('assets/dist/img/noimage.png')}}"
                    class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">

                <a href="{{$profile_route}}" class="d-block">{{$user->name}}</a>


            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview menu-open">
                    <a href="{{route('home')}}"
                       class="nav-link {{ (request()->is('/') || request()->is('dashboard')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('appointments.index')}}"
                       class="nav-link {{ request()->is('appointments/*') || request()->is('appointments')? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar-plus"></i>
                        <p>
                            Appointment
                        </p>
                    </a>
                </li>
                @ability('admin,recep','')
                <li class="nav-item">
                    <a href="#" class="nav-link {{ (request()->routeIS('doctors.*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-md"></i>
                        <p>
                            Doctors
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('doctors.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Doctors List</p>
                            </a>
                        </li>
                        @role('admin')
                        <li class="nav-item">
                            <a href="{{route('doctors.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New Doctor</p>
                            </a>
                        </li>
                        @endrole
                    </ul>
                </li>
                @endability

                @if($user->hasRole('admin'))
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ (request()->routeIs('receptionists.*')) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Receptionists
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('receptionists.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Receptionists List</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('receptionists.create')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add Receptionist</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if($user->hasRole(['admin','recep','doctor']))
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ (request()->routeIs('patients.*')) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-plus"></i>
                            <p>
                                Patients
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('patients.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Patients List</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('patients.create')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add New Patient</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('today-appointment')}}"
                           class="nav-link {{ request()->is('appointment-list/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar"></i>
                            <p>
                                Appointment List
                            </p>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a href="#" class="nav-link {{ (request()->routeIs('prescriptions.*')) ? 'active' : '' }}">
                        <span class="nav-icon material-icons">edit_document</span>
                        <p>
                            Prescriptions
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if($user->hasRole(['admin','doctor']))
                            <li class="nav-item">
                                <a href="{{route('prescriptions.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Prescriptions List</p>
                                </a>
                            </li>
                        @endif
                        @if($user->hasRole('doctor'))
                            <li class="nav-item">
                                <a href="{{route('prescriptions.create')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Create Prescription</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ (request()->routeIs('prescriptionss.*')) ? 'active' : '' }}">
                        <span class="nav-icon material-icons">settings_accessibility</span>
                        <p>
                            Sessions
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('sessions.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sessions List</p>
                            </a>
                        </li>
                        @if($user->hasRole('doctor'))
                            <li class="nav-item">
                                <a href="{{route('sessions.create')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Create Session</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
{{--                <li class="nav-item">
                    <a href="#" class="nav-link {{ (request()->routeIs('invoices.*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-receipt"></i>
                        <p>
                            Invoices
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('patients.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Invoices List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('patients.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New Invoice</p>
                            </a>
                        </li>
                    </ul>
                </li>--}}
                @if($user->hasRole('admin'))
                    <li class="nav-item">
                        <a href="{{route('incomes.index')}}"
                           class="nav-link {{ (request()->routeIs('incomes.*')) ? 'active' : '' }}">
                            <i class="nav-icon material-icons">file_download</i>
                            <p>
                                Incomes
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('expenses.index')}}"
                           class="nav-link {{ (request()->routeIs('expenses.*')) ? 'active' : '' }}">
                            <i class="nav-icon material-icons">file_upload</i>
                            <p>
                                Expenses
                            </p>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="#" class="nav-link {{ Request::segment(1) === 'settings' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Settings
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if($user->hasRole('admin'))
                            <li class="nav-item">
                                <a href="{{route('expense-types.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Expense Types</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('income-types.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Income Types</p>
                                </a>
                            </li>
                        @endif
                        @if($user->hasRole('doctor'))
                            <li class="nav-item">
                                <a href="{{route('formulas.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Formulas</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('frequency-types.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Frequency Types</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('period-types.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Period Types</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('session-types.index')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Session Types</p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{route('prescription-designs.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Prescription Design</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
