@php $user = auth()->user(); @endphp
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link">
        <img src="{{asset('assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Pulpo Clinic</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{!empty(auth()->user()->profile_photo_path) ? asset('assets/images/users/'.auth()->user()->profile_photo_path) : asset('assets/dist/img/noimage.png')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{auth()->user()->name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview menu-open">
                    <a href="{{route('home')}}" class="nav-link {{ (request()->is('/') || request()->is('dashboard')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('appointments.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-calendar"></i>
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
                        <i class="nav-icon fas fa-user-md"></i>
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
                @endif
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-calendar"></i>
                        <p>
                            Appointment List
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
