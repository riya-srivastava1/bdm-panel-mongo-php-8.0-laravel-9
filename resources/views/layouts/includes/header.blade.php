<div id="header" class="app-header">
    <!-- BEGIN navbar-header -->
    <div class="navbar-header">
        <a href="javascript:;" class="navbar-brand"><span class="navbar-logo"></span> <b>BDM</b>Panel</a>
        <button type="button" class="navbar-mobile-toggler" data-toggle="app-sidebar-mobile">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <!-- END navbar-header -->
    <!-- BEGIN header-nav -->
    <div class="navbar-nav">
        <!-- <div class="navbar-item navbar-form">
            <form action="javascript:;" method="POST" name="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Enter keyword" />
                    <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div> -->

        <div class="navbar-item navbar-user dropdown">
            <a href="javascript:;" class="navbar-link dropdown-toggle d-flex align-items-center"
                data-bs-toggle="dropdown">
                @if (Auth::user()->image)
                    <img src="{{ asset('') }}{{ Auth::user()->image ?? '' }}" alt="{{ asset('assets/img/person-dummy-e1553259379744.jpg') }}" />
                @else
                    <img src="{{ asset('assets/img/person-dummy-e1553259379744.jpg') }}" alt="{{ asset('assets/img/person-dummy-e1553259379744.jpg') }}" />
                @endif
                <span>
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end me-1">
                <a href="{{route('profile.edit')}}" class="dropdown-item">Edit Profile</a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item">logout</a>
            </div>
        </div>
    </div>
    <!-- END header-nav -->
</div>
