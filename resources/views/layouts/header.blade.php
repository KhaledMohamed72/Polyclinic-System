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


<!-- Right navbar links -->
    <ul class="navbar-nav"
        style="@if(\Jenssegers\Agent\Facades\Agent::isMobile()) margin-left:40%; @else margin-left:auto; @endif">
        <!-- Language Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fa fa-language"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-lg-right">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)

                    <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                        {{ $properties['native'] }}
                    </a>
                @endforeach

            </div>
        </li>
        <!-- User Dropdown Menu -->
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
                                {{ trans('main_trans.profile') }}
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
                                    {{ trans('main_trans.schedule') }}
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
                                {{ trans('main_trans.change_password') }}
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
                                {{ trans('main_trans.logout') }}
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
    </ul>

</nav>
