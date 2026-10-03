<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper d-flex  gap-2 d-flex flex-column">
            <a href="" class="d-flex justify-content-start">
                <img style="width: 100px;" class="img-fluid for-light" src="{{ asset('assets/images/mcware-logo.png') }}"
                    alt="Logo">
                <img style="width: 100px;" class="img-fluid for-dark" src="{{ asset('assets/images/mcware-logo.png') }}"
                    alt="Logo Dark">
                     <!-- <h4 class="mb-0  ms-1 text-center  fw-bold">
                {{ auth()->user()->hasRole('admin') ? 'Admin' : 'User' }}
            </h4> -->
            </a>
           
            <div class="back-btn ms-3"><i class="fa fa-angle-left"></i></div>
        </div>

        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>

            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">


                    <li class="back-btn">
                        <a href="{{ url('/') }}">

                        </a>
                        <div class="mobile-back text-end"><span>Back</span></div>
                    </li>

                    @role('user')
                        <li class="sidebar-list">

                            <a class="sidebar-link sidebar-title link-nav d-flex flex-row gap-2 align-items-center {{ request()->routeIs('admin.users.show') ? 'active1' : '' }}"
                                href="{{ route('admin.users.show', auth()->id()) }}">
                               <i class="fa fa-user"></i>
                                <span>Profile</span>
                            </a>

                        </li>
                    @endrole


                    @role('admin')
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav d-flex flex-row gap-2 align-items-center {{ request()->routeIs('admin.users.index') || request()->routeIs('admin.users.create') || request()->routeIs('admin.users.edit') || request()->routeIs('admin.users.show') ? 'active1' : '' }}" href="{{ route('admin.users.index') }}">
                               <i class="fa fa-users"></i>
                                <span>User List</span>
                            </a>
                        </li>
                    @endrole
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav d-flex flex-row gap-2 align-items-center {{ request()->routeIs('tickets.*') ? 'active1' : '' }}" href="{{ route('tickets.index') }}">
                           <i class="fa fa-ticket"></i>
                            <span>Tickets</span>
                        </a>
                    </li>

                    @role('admin')
                        <li class="sidebar-list">

                            <a class="sidebar-link sidebar-title link-nav d-flex flex-row gap-2 align-items-center {{ request()->routeIs('installations.*') ? 'active1' : '' }}" href="{{ route('installations.index') }}">
                                <i class="fa fa-wifi"></i>
                                <span>Installations</span>
                            </a>

                        </li>
                    @endrole
                    @role('admin')
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav d-flex flex-row gap-2 align-items-center {{ request()->routeIs('complaints.*') ? 'active1' : '' }}" href="{{ route('complaints.index') }}">
                                <i class="fa fa-whatsapp text-white"></i>
                                <span>Whatsapp Complaints</span>
                            </a>
                        </li>
                    @endrole

                    <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav d-flex flex-row gap-2 align-items-center {{ request()->routeIs('internetdata*') ? 'active1' : '' }}" href="{{ route('internetdata.index') }}">
                                <i class="fa fa-globe"></i>
                                <span>Internet Data</span>
                            </a>
                        </li>
                    <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav d-flex flex-row gap-2 align-items-center {{ request()->routeIs('members_called.*') ? 'active1' : '' }}" href="{{ route('members_called.index') }}">
                                   <i class="fa fa-medkit"></i>
                                <span>Clinic Issues</span>
                            </a>
                        </li>

                    @role('admin')
                        <li class="sidebar-list">

                            <a class="sidebar-link sidebar-title d-flex flex-row gap-2 align-items-center {{ request()->routeIs('phcs.*') || request()->routeIs('corporations.*') || request()->routeIs('zones.*') || request()->routeIs('constituencies.*') || request()->routeIs('wards.*') ? 'active1' : '' }}" href="javascript:void(0)">
                                <i class="fa fa-database"></i>
                                <span>Masters</span>
                            </a>

                            <ul class="sidebar-submenu"> 
                                <li>
                                    <a href="{{ route('phcs.index') }}">PHCs</a>    
                                </li>
                                <li>
                                    <a href="{{ route('corporations.index') }}">Corporations</a>
                                </li>
                                <li>
                                    <a href="{{ route('zones.index') }}">Zones</a>
                                </li>
                                <li>
                                    <a href="{{ route('constituencies.index') }}">Constituencies</a>
                                </li>
                                <li>
                                    <a href="{{ route('wards.index') }}">Wards</a>
                                </li>
                            </ul>

                        </li>
                    @endrole




                </ul>
            </div>

            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
<style>
.simplebar-mask {
    top: 72px !important;
}

.simplebar-mask {
    background: linear-gradient(164deg, #3b5fa5, #2f4f8f) !important;
}

.simplebar-content {
    margin-top: 15px !important;
}

.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .sidebar-links li a span {
    color: #fff;
}

.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .sidebar-links .simplebar-wrapper .simplebar-mask .simplebar-content-wrapper .simplebar-content>li a {
    color: #fff;
}

.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .sidebar-links .simplebar-wrapper .simplebar-mask .simplebar-content-wrapper .simplebar-content>li .sidebar-link:hover {
    background: #ededed !important;
    color: #000 !important;
}

.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .sidebar-links .simplebar-wrapper .simplebar-mask .simplebar-content-wrapper .simplebar-content>li .sidebar-link span:hover {

    color: #000 !important;
}


.sidebar-link.active {
    background: #ededed !important;
    color: #000 !important;
    border-radius: 8px;
    /* optional for better look */
}

/* Make icon also black when active */
.sidebar-link.active i {
    color: #000 !important;
}

/* Active state overrides for text and span */
.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .sidebar-links li a.sidebar-link.active span {
    color: #000 !important;
}

.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .sidebar-links .simplebar-wrapper .simplebar-mask .simplebar-content-wrapper .simplebar-content>li a.sidebar-link.active {
    color: #000 !important;
}

.page-wrapper.compact-wrapper .page-body-wrapper .page-body {
    background: #f6fdff94 !important;
}

.logo-wrapper {
    background: transparent !important;
}
.logo-wrapper img{
  height: 50px !important;
  width: auto !important;
}

.header-wrapper {
    background: #f6fdff94 !important;
}

.page-wrapper .page-header .header-wrapper {
    padding: 10px 10px !important;
    /* border-radius: 8px; */
}

.sidebar-list .sidebar-link.active,
.sidebar-list .sidebar-link.active1 {
    background: #ededed !important;
    color: #000 !important;
}

/* Make icon also black when active */
.sidebar-list .sidebar-link.active i,
.sidebar-list .sidebar-link.active1 i {
    color: #000 !important;
}

.sidebar-list .sidebar-link.active i,
.sidebar-list .sidebar-link.active1 span {
    color: #000 !important;
}
/* Fix active text color with more specific selectors */
.sidebar-list .sidebar-link.active span,
.sidebar-list .sidebar-link.active1 span {
    color: #000 !important;
}

/* More specific selector for active main links */
.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .sidebar-links li.sidebar-list .sidebar-link.active span,
.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .sidebar-links li.sidebar-list .sidebar-link.active1 span {
    color: #000 !important;
}

/* Active submenu items */
.sidebar-submenu li a.active-sub {
    background: #ededed !important;
    color: #000 !important;
    border-radius: 8px;
}

/* Active submenu text */
.sidebar-submenu li a.active-sub span,
.sidebar-submenu li a.active-sub i {
    color: #000 !important;
}

/* More specific active submenu selector */
.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .sidebar-links .simplebar-wrapper .simplebar-mask .simplebar-content-wrapper .simplebar-content>li .sidebar-submenu li a.active-sub {
    color: #000 !important;
}
.page-wrapper.compact-wrapper .page-body-wrapper .according-menu i {
    color:#ddba93 !important;
}

.sidebar-menu-icon {
    width: 18px;
    text-align: center;
    font-size: 1rem;
    color: #ddba93 !important;
}

.sidebar-badge {
    margin-left: auto;
    min-width: 22px;
    height: 22px;
    padding: 0 7px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 999px;
    background: #ff6b35;
    color: #fff !important;
    font-size: 11px;
    font-weight: 700;
    line-height: 1;
    box-shadow: 0 2px 8px rgba(255, 107, 53, 0.35);
}

/* =========================
   SIDEBAR BUBBLY BACKGROUND
========================= */
.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper {
   
    background: #fff !important;
    z-index: 1;
    /* border-radius: 0 20px 20px 0; */
}
/* Bubble Top Right */
.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper::before {
    content: "";
    position: absolute;
    width: 170px;
    height: 170px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.08);
    top: -40px;
    right: -50px;
    z-index: 0;
}

/* Bubble Bottom Left */
.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper::after {
    content: "";
    position: absolute;
    width: 140px;
    height: 140px;
    border-radius: 50%;
    /* background: rgba(255, 255, 255, 0.06); */
    bottom: 80px;
    left: -40px;
    z-index: 0;
}
.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .sidebar-links .simplebar-wrapper .simplebar-mask .simplebar-content-wrapper .simplebar-content>li .sidebar-submenu li a{
    color: #fff !important;
}
/* Add these styles to fix hover effects */

/* Main sidebar links hover */
.sidebar-list .sidebar-link:hover {
    background: #ededed !important;
    color: #000 !important;
    border-radius: 8px;
}

/* Icon color on hover */
.sidebar-list .sidebar-link:hover .sidebar-menu-icon {
    color: #000 !important;
}

/* Submenu links hover */
.sidebar-submenu li a:hover {
    background: #ededed !important;
    color: #000 !important;
    border-radius: 8px;
}

/* Submenu icon hover */
.sidebar-submenu li a:hover i {
    color: #000 !important;
}

/* Ensure hover works for all sidebar links */
.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .sidebar-links li.sidebar-list .sidebar-link:hover {
    background: #ededed !important;
    color: #000 !important;
}
/* Fix text color on hover with more specific selectors */
.sidebar-list .sidebar-link:hover span {
    color: #000 !important;
}

/* More specific selector for main links */
.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .sidebar-links li.sidebar-list .sidebar-link:hover span {
    color: #000 !important;
}

/* Submenu text hover with more specific selector */
.page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .sidebar-links .simplebar-wrapper .simplebar-mask .simplebar-content-wrapper .simplebar-content>li .sidebar-submenu li a:hover {
    color: #000 !important;
}

/* Submenu text span hover */
.sidebar-submenu li a:hover span {
    color: #000 !important;
}

 </style>