<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
        </ul>

    </form>

    @php
        $notification = \App\Models\OrderPlacedNotification::where('seen', 0)
            ->latest()
            ->take(10)
            ->get();
        $unseenMessages = \App\Models\Chat::where([
            'receiver_id' => auth()->user()->id,
            'seen' => 0,
        ])->count();
    @endphp

    <ul class="navbar-nav navbar-right">

        {{-- envelope --}}
        <li class="dropdown dropdown-list-toggle">
            <a href="{{ route('admin.chat-index') }}"
                class="nav-link nav-link-lg message-envelope
            {{ $unseenMessages > 0 ? 'beep' : '' }}"><i
                    class="far fa-envelope"></i></a>

        </li>



        {{-- bell --}}
        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                class="nav-link notification-toggle nav-link-lg notification_beep @if (count($notification) > 0) beep @endif
            ">
                <i class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Notifications
                    <div class="float-right">
                        <a href="{{ route('admin.clear-notification') }}">Mark All As Read</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-icons rt_notification">

                    @foreach ($notification as $n)
                        <a href="{{ route('admin.orders.show', $n->order_id) }}" class="dropdown-item">
                            <div class="dropdown-item-icon bg-info text-white">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div class="dropdown-item-desc">
                                {{ $n->message }}
                                <div class="time">{{ date('h:i A | d-F-Y', strtotime($n->created_at)) }}</div>
                            </div>
                        </a>
                    @endforeach

                </div>
                <div class="dropdown-footer text-center">
                    <a href="{{ route('admin.order.index') }}">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li>


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
            <li class="{{ Request::is('admin/slider*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dailyOffers.index') }}">
                    <i class="fas fa-tags"></i> Today Offers
                </a>
            </li>
            <li class="{{ Request::is('admin/why-choose-us*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.why-choose-us.index') }}">
                    <i class="fas fa-lightbulb"></i>Why choose us
                </a>
            </li>


            <li
                class="dropdown  {{ Request::is('admin/order*') || Request::is('admin/pending*') || Request::is('admin/in-process*') || Request::is('admin/delivered*') || Request::is('admin/declined*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fa fa-columns"></i><span>Orders</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('admin/order*') ? 'active' : '' }}">
                        <a href="{{ route('admin.order.index') }}" class="nav-link">All Orders</a>
                    </li>
                    <li class="{{ Request::is('admin/pending*') ? 'active' : '' }}">
                        <a href="{{ route('admin.pending-orders') }}" class="nav-link">Pending Orders</a>
                    </li>
                    <li class="{{ Request::is('admin/in-process*') ? 'active' : '' }}">
                        <a href="{{ route('admin.in-process-orders') }}" class="nav-link">In Process Orders</a>
                    </li>
                    <li class="{{ Request::is('admin/declined*') ? 'active' : '' }}">
                        <a href="{{ route('admin.declined-orders') }}" class="nav-link">Declined Orders</a>
                    </li>
                    <li class="{{ Request::is('admin/delivered*') ? 'active' : '' }}">
                        <a href="{{ route('admin.delivered-orders') }}" class="nav-link">Delivered Orders</a>
                    </li>

                </ul>
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
                class="dropdown  {{ Request::is('admin/coupon*') || Request::is('admin/delivery-area*') || Request::is('admin/payment-gateway*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fa fa-columns"></i><span>Manage Ecommerce</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('admin/coupon*') ? 'active' : '' }}">
                        <a href="{{ route('admin.coupon.index') }}" class="nav-link">Coupon</a>
                    </li>
                    <li class="{{ Request::is('admin/delivery-area*') ? 'active' : '' }}">
                        <a href="{{ route('admin.delivery-area.index') }}" class="nav-link">Delivery Areas</a>
                    </li>
                    <li class="{{ Request::is('admin/payment-gateway*') ? 'active' : '' }}">
                        <a href="{{ route('admin.payment-setting.index') }}" class="nav-link">Payment Gateways</a>
                    </li>
                </ul>
            </li>


            <li class="{{ Request::is('admin/chat*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.chat-index') }}"><i class="fas fa-wrench"></i>Messages</a>
            </li>
            <li class="{{ Request::is('admin/setting*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.setting.index') }}"><i
                        class="fas fa-wrench"></i>Settings</a>
            </li>
        </ul>
    </aside>
</div>
