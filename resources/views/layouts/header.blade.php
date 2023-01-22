@php
    if (auth()->user()->hasRole('admin')){
    $profile_route = route('home');
}
    if (auth()->user()->hasRole('doctor')){
    $profile_route = route('doctors.show', auth()->user()->id);
}
    if (auth()->user()->hasRole('recep')){
    $profile_route = route('receptionists.show', auth()->user()->id);
}
@endphp
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- SEARCH FORM -->
{{--    <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>--}}

<!-- Right navbar links -->
    <ul class="navbar-nav"
        style="@if(\Jenssegers\Agent\Facades\Agent::isMobile()) margin-left:12rem; @else margin-left:auto; @endif">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="{{ $profile_route }}" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                <span class="text-sm text-primary"><i class="fas fa-user-circle"></i></span>
                                {{ __('Profile') }}
                            </h3>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                @if(auth()->user()->hasRole('doctor'))
                    <a href="{{ route('schedule-create',auth()->user()->id) }}" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    <span class="text-sm text-primary"><i class="fas fa-calendar-week"></i></span>
                                    {{ __('Schedule') }}
                                </h3>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                @endif
                <a href="{{ route('change-password') }}" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                <span class="text-sm text-primary"><i class="fas fa-edit"></i></span>
                                {{ __('Change Password') }}
                            </h3>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                   class="dropdown-item mt-2">
                    <!-- Message Start -->
                    <div class="media">
                        <div class="media-body">
                            <h3 class="dropdown-item-title text-red">
                                <span class="text-sm text-danger"><i class="fas fa-sign-out-alt"></i></span>
                                {{ __('Logout') }}
                            </h3>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
            </div>
        </li>
        <form method="get" id="logout-form" action="{{route('logout')}}">
            @csrf
        </form>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            {{--<a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>--}}
        </li>
    </ul>
</nav>
