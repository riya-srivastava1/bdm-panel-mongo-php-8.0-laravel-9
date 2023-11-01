<!-- BEGIN #sidebar -->
<div id="sidebar" class="app-sidebar app-sidebar-transparent">
    <!-- BEGIN scrollbar -->
    <div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
        <!-- BEGIN menu -->
        <div class="menu">
            <div class="menu-search mb-n3">
                <input type="text" class="form-control" placeholder="Sidebar menu filter..."
                    data-sidebar-search="true" />
            </div>
            <div id="appSidebarProfileMenu" class="collapse">
                <div class="menu-item pt-5px">
                    <a href="javascript:;" class="menu-link">
                        <div class="menu-icon"><i class="fa fa-cog"></i></div>
                        <div class="menu-text">Settings</div>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="javascript:;" class="menu-link">
                        <div class="menu-icon"><i class="fa fa-pencil-alt"></i></div>
                        <div class="menu-text"> Send Feedback</div>
                    </a>
                </div>
                <div class="menu-item pb-5px">
                    <a href="javascript:;" class="menu-link">
                        <div class="menu-icon"><i class="fa fa-question-circle"></i></div>
                        <div class="menu-text"> Helps</div>
                    </a>
                </div>
                <div class="menu-divider m-0"></div>
            </div>
            <div class="menu-header">Navigation</div>
            <div class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fas fa-dashboard"></i>
                    </div>
                    <div class="menu-text">Dashboard</div>
                </a>
            </div>
            <div class="menu-item {{ request()->routeIs('user.list') ? 'active' : '' }}">
                <a href="{{ route('user.list') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fas fa-circle-user"></i>
                    </div>
                    <div class="menu-text">Users</div>
                </a>
            </div>
            <div class="menu-item {{ request()->routeIs('bookings') ? 'active' : '' }}">
                <a href="{{ route('bookings') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="menu-text">Today's Booking</div>
                </a>
            </div>
            <div class="menu-item {{ request()->routeIs('wah.artist.log') ? 'active' : '' }}">
                <a href="{{ route('wah.artist.log') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-history"></i>
                    </div>
                    <div class="menu-text">Artist Log</div>
                </a>
            </div>
            <div class="menu-item {{ request()->routeIs('wah.bookings') ? 'active' : '' }}">
                <a href="{{ route('wah.bookings') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="menu-text">WAH Bookings</div>
                </a>
            </div>
            <div class="menu-item {{ request()->routeIs('wah.location') ? 'active' : '' }}">
                <a href="{{ route('wah.location') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fas fa-location-dot"></i>
                    </div>
                    <div class="menu-text">WAH Location</div>
                </a>
            </div>
            <div class="menu-item {{ request()->routeIs('wah.category') ? 'active' : '' }}">
                <a href="{{ route('wah.category') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa-solid fa-qrcode"></i>
                    </div>
                    <div class="menu-text">WAH Category</div>
                </a>
            </div>
            <div class="menu-item {{ request()->routeIs('wah.service') ? 'active' : '' }}">
                <a href="{{ route('wah.service') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-list-alt"></i>
                    </div>
                    <div class="menu-text">WAH Services</div>
                </a>
            </div>
            <div class="menu-item {{ request()->routeIs('wah.sub.services') ? 'active' : '' }}">
                <a href="{{ route('wah.sub.services') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-wrench"></i>
                    </div>
                    <div class="menu-text">WAH Sub Services</div>
                </a>
            </div>
            <div class="menu-item {{ request()->routeIs('wah.equipment') ? 'active' : '' }}">
                <a href="{{ route('wah.equipment') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-paint-brush"></i>
                    </div>
                    <div class="menu-text">WAH Artist Equipments</div>
                </a>
            </div>
            <div class="menu-item {{ request()->routeIs('wah.artist') ? 'active' : '' }}">
                <a href="{{ route('wah.artist') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fas fa-palette"></i>
                    </div>
                    <div class="menu-text">WAH Artist</div>
                </a>
            </div>
            <div class="menu-item {{ request()->routeIs('wah.artist.wwu') ? 'active' : '' }}">
                <a href="{{ route('wah.artist.wwu') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="menu-text">WWU Request</div>
                </a>
            </div>
            <div class="menu-item {{ request()->routeIs('wah.artist.on.map') ? 'active' : '' }}">
                <a href="{{ route('wah.artist.on.map') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa-solid fa-map"></i>
                    </div>
                    <div class="menu-text">Artist on MAP</div>
                </a>
            </div>
            <div class="menu-item {{ request()->routeIs('pay-status') ? 'active' : '' }}">
                <a href="{{ route('pay-status') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-credit-card"></i>
                    </div>
                    <div class="menu-text">Paytm</div>
                </a>
            </div>
            <!-- BEGIN minify-button -->
            <div class="menu-item d-flex">
                <a href="javascript:;" class="app-sidebar-minify-btn ms-auto" data-toggle="app-sidebar-minify"><i
                        class="fa fa-angle-double-left"></i></a>
            </div>
            <!-- END minify-button -->
        </div>
        <!-- END menu -->
    </div>
    <!-- END scrollbar -->
</div>
<div class="app-sidebar-bg"></div>
<div class="app-sidebar-mobile-backdrop"><a href="#" data-dismiss="app-sidebar-mobile"
        class="stretched-link"></a>
</div>
<!-- END #sidebar -->
