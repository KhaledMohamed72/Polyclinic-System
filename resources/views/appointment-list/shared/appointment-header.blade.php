<ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
    <li class="nav-item">
        <a class="nav-link {{ request()->is('appointment-list/today-appointment') ? 'active' : '' }}" href="{{route('today-appointment')}}">
            <span class="d-block d-sm-none"><i class="fas fa-calendar-day"></i></span>
            <span class="d-none d-sm-block">{{ trans('main_trans.todays_appointment') }} </span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('appointment-list/pending-appointment') ? 'active' : '' }}" href="{{route('pending-appointment')}}">
            <span class="d-block d-sm-none"><i class="far fa-calendar"></i></span>
            <span class="d-none d-sm-block">{{ trans('main_trans.pending_appointment_list') }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('appointment-list/upcoming-appointment') ? 'active' : '' }}" href="{{route('upcoming-appointment')}}">
            <span class="d-block d-sm-none"><i class="fas fa-calendar-week"></i></span>
            <span class="d-none d-sm-block">{{ trans('main_trans.upcoming_appointment_list') }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('appointment-list/complete-appointment') ? 'active' : '' }}" href="{{route('complete-appointment')}}">
            <span class="d-block d-sm-none"><i class="fas fa-check-square"></i></span>
            <span class="d-none d-sm-block">{{ trans('main_trans.complete_appointment') }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('appointment-list/cancel-appointment') ? 'active' : '' }}" href="{{route('cancel-appointment')}}">
            <span class="d-block d-sm-none"><i class="fas fa-window-close"></i></span>
            <span class="d-none d-sm-block">{{ trans('main_trans.cancel_appointment_list') }}</span>
        </a>
    </li>
</ul>
