<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
        </ul>

    </form>
    <ul class="navbar-nav navbar-right">

        <li class="dropdown"><a href="{{ route('admin.dashboard') }}" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset(auth()->user()->avatar) }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Logged in 5 min ago</div>
                <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <a href="features-activities.html" class="dropdown-item has-icon">
                    <i class="fas fa-bolt"></i> Activities
                </a>
                <a href="features-settings.html" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <div class="dropdown-divider"></div>


                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a href="#" class="dropdown-item has-icon text-danger"
                        onclick="event.preventDefault();
                    this.closest('form').submit();">

                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>

                </form>


            </div>
        </li>
    </ul>
</nav>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fire"></i>General
                </a>
            </li>

            <li class="menu-header">Starter</li>

            <li class="{{ Request::is('admin/slider*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.slider.index') }}">
                    <i class="fas fa-sliders-h"></i>Slider
                </a>
            </li>
            <li class="{{ Request::is('admin/why-choose-us*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.why-choose-us.index') }}">
                    <i class="fas fa-lightbulb"></i>Why choose us
                </a>
            </li>

            <li
                class="dropdown  {{ Request::is('admin/category*') || Request::is('admin/product*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fa fa-columns"></i><span>Manage Restaurant</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('admin/category*') ? 'active' : '' }}">
                        <a href="{{ route('admin.category.index') }}" class="nav-link">Product Categories</a>
                    </li>
                    <li class="{{ Request::is('admin/product*') ? 'active' : '' }}">
                        <a href="{{ route('admin.product.index') }}" class="nav-link">Products</a>
                    </li>
                </ul>
            </li>

            {{-- manage ecommerce dropdown --}}
            <li
                class="dropdown  {{ Request::is('admin/category*') || Request::is('admin/product*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fa fa-columns"></i><span>Manage Ecommerce</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('admin/coupon*') ? 'active' : '' }}">
                        <a href="{{ route('admin.coupon.index') }}" class="nav-link">Coupon</a>
                    </li>
                </ul>
            </li>


            <li class="{{ Request::is('admin/setting*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.setting.index') }}"><i class="fas fa-wrench"></i>Settings</a>
            </li>
        </ul>
    </aside>
</div>
