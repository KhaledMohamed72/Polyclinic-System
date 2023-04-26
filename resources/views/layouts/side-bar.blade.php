@php
    $user = auth()->user();
    if ($user->hasRole('admin')) {
        $profile_route = '#';
    }
    if ($user->hasRole('doctor')) {
        $profile_route = route('doctors.show', auth()->user()->id);
    }
    if ($user->hasRole('recep')) {
        $profile_route = route('receptionists.show', auth()->user()->id);
    }
@endphp
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
        <img src="{{ asset('assets/dist/img/pulpo-logo.jpg') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Pulpo Clinic</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ !empty($user->profile_photo_path) ? asset('images/users/' . $user->profile_photo_path) : asset('assets/dist/img/noimage.png') }}"
                    class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">

                <a href="{{ $profile_route }}" class="d-block">{{ $user->name }}</a>


            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2" style="font-size: small">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview menu-open">
                    <a href="{{ route('home') }}"
                        class="nav-link {{ request()->is('/') || request()->is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        {{ trans('main_trans.dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('appointments.index') }}"
                        class="nav-link {{ request()->is('appointments/*') || request()->is('appointments') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar-plus"></i>
                        <p>
                            {{ trans('main_trans.appointment_calendar') }}
                        </p>
                    </a>
                </li>
                @ability('admin,recep', '')
                    <li class="nav-item {{ request()->routeIS('doctors.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIS('doctors.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-md"></i>
                            <p>
                                {{ trans('main_trans.doctors') }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('doctors.index') }}"
                                    class="nav-link {{ request()->routeIS('doctors.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ trans('main_trans.doctor_list') }}</p>
                                </a>
                            </li>
                            @role('admin')
                                <li class="nav-item">
                                    <a href="{{ route('doctors.create') }}"
                                        class="nav-link {{ request()->routeIS('doctors.create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ trans('main_trans.add_new_doctor') }}</p>
                                    </a>
                                </li>
                            @endrole
                        </ul>
                    </li>
                @endability
                @if ($user->hasRole('admin'))
                    <li class="nav-item {{ request()->routeIS('receptionists.*') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->routeIs('receptionists.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                {{ trans('main_trans.receptionists') }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('receptionists.index') }}"
                                    class="nav-link {{ request()->routeIs('receptionists.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ trans('main_trans.receptionists_list') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('receptionists.create') }}"
                                    class="nav-link {{ request()->routeIs('receptionists.create') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ trans('main_trans.add_receptionist') }}</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if ($user->hasRole(['admin', 'recep', 'doctor']))
                    <li class="nav-item {{ request()->routeIS('patients.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('patients.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-plus"></i>
                            <p>
                                {{ trans('main_trans.patients') }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('patients.index') }}"
                                    class="nav-link {{ request()->routeIS('patients.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ trans('main_trans.patients_list') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('patients.create') }}"
                                    class="nav-link {{ request()->routeIS('patients.create') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ trans('main_trans.add_new_patient') }}</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('today-appointment') }}"
                        class="nav-link {{ request()->routeIs('today-appointment') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar"></i>
                        <p>
                            {{ trans('main_trans.appointments_list') }}
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIS('prescriptions.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('prescriptions.*') ? 'active' : '' }}">
                        <span class="nav-icon material-icons">edit_document</span>
                        <p>
                            {{ trans('main_trans.prescriptions') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if ($user->hasRole(['admin', 'recep', 'doctor']))
                            <li class="nav-item">
                                <a href="{{ route('prescriptions.index') }}"
                                    class="nav-link {{ request()->routeIs('prescriptions.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ trans('main_trans.prescriptions_list') }}</p>
                                </a>
                            </li>
                        @endif
                        @if ($user->hasRole('doctor'))
                            <li class="nav-item">
                                <a href="{{ route('prescriptions.create') }}"
                                    class="nav-link {{ request()->routeIs('prescriptions.create') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ trans('main_trans.create_prescription') }}</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->routeIs('sessions.*') ? 'active' : '' }}">
                        <span class="nav-icon material-icons">settings_accessibility</span>
                        <p>
                            {{ trans('main_trans.sessions') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('sessions.index') }}"
                                class="nav-link {{ request()->routeIs('sessions.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ trans('main_trans.sessions_list') }}</p>
                            </a>
                        </li>
                        @if ($user->hasRole('doctor'))
                            <li class="nav-item">
                                <a href="{{ route('sessions.create') }}"
                                    class="nav-link {{ request()->routeIs('sessions.create') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ trans('main_trans.create_session') }}</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                @if ($user->hasRole('admin'))
                    <li class="nav-item">
                        <a href="{{ route('incomes.index') }}"
                            class="nav-link {{ request()->routeIs('incomes.*') ? 'active' : '' }}">
                            <i class="nav-icon material-icons">file_download</i>
                            <p>
                                {{ trans('main_trans.incomes') }}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('expenses.index') }}"
                            class="nav-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
                            <i class="nav-icon material-icons">file_upload</i>
                            <p>
                                {{ trans('main_trans.expenses') }}
                            </p>
                        </a>
                    </li>
                @endif
                <li class="nav-item {{ Request::segment(1) === 'settings' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::segment(1) === 'settings' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            {{ trans('main_trans.settings') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if ($user->hasRole('admin'))
                            <li class="nav-item">
                                <a href="{{ route('expense-types.index') }}"
                                    class="nav-link {{ request()->routeIs('expense-types.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ trans('main_trans.expens_types') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('income-types.index') }}"
                                    class="nav-link {{ request()->routeIs('income-types.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ trans('main_trans.income_types') }}</p>
                                </a>
                            </li>
                        @endif
                        @if ($user->hasRole(['doctor', 'recep', 'admin']))
                            <li class="nav-item">
                                <a href="{{ route('insurance-companies.index') }}"
                                    class="nav-link {{ request()->routeIs('insurance-companies.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ trans('main_trans.insurance_companies') }}</p>
                                </a>
                            </li>
                        @endif
                        @if ($user->hasRole('doctor'))
                            <li class="nav-item">
                                <a href="{{ route('formulas.index') }}"
                                    class="nav-link {{ request()->routeIs('formulas.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ trans('main_trans.formulas') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('frequency-types.index') }}"
                                    class="nav-link {{ request()->routeIs('frequency-types.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ trans('main_trans.frequency_types') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('period-types.index') }}"
                                    class="nav-link {{ request()->routeIs('period-types.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ trans('main_trans.period_types') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('session-types.index') }}"
                                    class="nav-link {{ request()->routeIs('session-types.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ trans('main_trans.session_types') }}</p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('prescription-designs.index') }}"
                                class="nav-link {{ request()->routeIs('prescription-designs.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ trans('main_trans.prescription_design') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @if ($user->hasRole(['admin', 'doctor', 'recep']))
                    <li class="nav-item">
                        <a href="{{ route('reports.index') }}"
                            class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                            <i class="nav-icon material-icons">summarize</i>
                            <p>
                                {{ trans('main_trans.reports') }}
                            </p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
