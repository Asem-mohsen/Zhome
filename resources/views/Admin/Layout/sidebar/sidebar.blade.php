<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('Dashboard.index') }}" class="brand-link">
        <img src="{{ asset('Admin/dist/img/web/Logo/Icon.png') }}" alt="Zhome Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Zhome</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('Admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('Admins.profile' ,  Auth::guard('web')->user()->id)}}" class="d-block">
                    <p>{{ Auth::guard('web')->user()->name }}</p>
                </a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('Dashboard.index') }}"
                        class="nav-link {{ request()->routeIs('index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                {{-- Website --}}
                <li class="nav-item">
                    <a href="{{ config('app.frontend_url') }}" target="_blank" class="nav-link ">
                        <i class="nav-icon fa-solid fa-desktop"></i>
                        <p>
                            Website
                        </p>
                    </a>
                </li>
                {{-- Admins --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-user-tie"></i>
                        <p>
                            Admins
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('Admins.index') }}"
                                class="nav-link {{ request()->routeIs('Admins.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Admins</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('Roles.index') }}"
                                class="nav-link {{ request()->routeIs('Roles.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Users --}}
                <li class="nav-item">
                    <a href="{{ route('Users.index') }}"
                        class="nav-link {{ request()->routeIs('Users.index') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-users"></i>
                        <p>
                            Users
                        </p>
                    </a>
                </li>
                {{-- Products --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-box-open"></i>
                        <p>
                            Products
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('Products.index') }}"
                                class="nav-link {{ request()->routeIs('Products.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('Category.index') }}"
                                class="nav-link {{ request()->routeIs('Category.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('Brands.index') }}"
                                class="nav-link {{ request()->routeIs('Brands.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Brands</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('Platform.index') }}"
                                class="nav-link {{ request()->routeIs('Platform.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Platforms</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Features --}}
                <li class="nav-item">
                    <a href="{{ route('Features.index') }}"
                        class="nav-link {{ request()->routeIs('Features.index') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-star"></i>
                        <p>
                            Features
                        </p>
                    </a>
                </li>
                {{-- Collections --}}
                <li class="nav-item">
                    <a href="{{ route('Collections.index') }}"
                        class="nav-link {{ request()->routeIs('Collections.index') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-object-group"></i>
                        <p>
                            Collections
                        </p>
                    </a>
                </li>
                {{-- Payments --}}
                <li class="nav-item">
                    <a href="{{ route('Payment.Admin.index') }}"
                        class="nav-link {{ request()->routeIs('Payment.Admin.index') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-money-bill-1-wave"></i>
                        <p>
                            Payments
                        </p>
                    </a>
                </li>
                {{-- Inventory --}}
                <li class="nav-item">
                    <a href="{{ route('Inventory.index') }}"
                        class="nav-link {{ request()->routeIs('Inventory.index') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-boxes-stacked"></i>
                        <p>
                            Stock
                        </p>
                    </a>
                </li>
                {{-- Shipping --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-truck"></i>
                        <p>
                            Shipping
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('Shipping.cost.index') }}"
                                class="nav-link {{ request()->routeIs('Shipping.cost.index') ? 'active' : '' }}">
                                <i class="fa-solid fa-money-bill-1"></i>
                                <p>Shipping Cost</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('Shipping.estimations.index') }}"
                                class="nav-link {{ request()->routeIs('Shipping.estimations.index') ? 'active' : '' }}">
                                <i class="fa-solid fa-file-signature"></i>
                                <p>Exceptions</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Orders --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-cart-shopping"></i>
                        <p>
                            Orders
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('Orders.ShopOrders.index') }}"
                                class="nav-link {{ request()->routeIs('Orders.ShopOrders.index') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-shop"></i>
                                <p>Shop</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('Orders.ToolsOrders.index') }}"
                                class="nav-link {{ request()->routeIs('Orders.ToolsOrder.index') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-store"></i>
                                <p>Tools</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Discounts --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-sack-dollar"></i>
                        <p>
                            Discounts
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('Sales.index') }}"
                                class="nav-link {{ request()->routeIs('Sales.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Discount</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('Sales.Promocode.index') }}"
                                class="nav-link {{ request()->routeIs('Sales.Promocode.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Promotions</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">Others</li>
                {{-- Subscribers --}}
                <li class="nav-item">
                    <a href="{{ route('Subscribers.index') }}"
                        class="nav-link {{ request()->routeIs('Subscribers.index') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-user-plus"></i>
                        <p>
                            Subscribers
                        </p>
                    </a>
                </li>
                {{-- Contact --}}
                <li class="nav-item">
                    <a href="{{ route('Contact.index') }}"
                        class="nav-link {{ request()->routeIs('Contact.index') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-address-card"></i>
                        <p>
                            Contact
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
