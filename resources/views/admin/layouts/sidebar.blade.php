<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="assets/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="assets/images/logo-dark.png" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="assets/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="assets/images/logo-light.png" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
            
                <!-- Danh mục -->
                <li class="nav-item">
<<<<<<< HEAD
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarDashboards">
=======
                    <a class="nav-link menu-link" href="#sidebarCategory" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCategory">
>>>>>>> 7d338e55e99648f0805aef3b86ebbd57123a62fb
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Danh mục</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarCategory">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">

                                <a href="{{ route('admin.categories.index')}}" class="nav-link" data-key="t-analytics"> Danh sách </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.categories.create')}}" class="nav-link" data-key="t-crm"> Thêm </a>
                            </li>
                        </ul>
                    </div>
                </li>
            
                <!-- Sản Phẩm -->
                <li class="nav-item">
<<<<<<< HEAD
                    <a class="nav-link menu-link" href="#sidebarProducts" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarProducts">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Sản phẩm</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarProducts">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">

                                <a href="{{ route('admin.products.index')}}" class="nav-link" data-key="t-analytics"> Danh sách </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.products.create')}}" class="nav-link" data-key="t-crm"> Thêm mới </a>
                            </li>
                        </ul>
                    </div>
                    
                </li> <!-- end Dashboard Menu -->

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarOrders" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarOrders">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Đơn hàng</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarOrders">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.orders.index') }}" class="nav-link" data-key="t-analytics">
                                    Danh sách
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarCharts" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarCharts">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Blog</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarCharts">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">

                                 {{-- <a href="{{ route('admin.blogs.index')}}" class="nav-link" data-key="t-analytics"> Danh sách </a> --}}
                            </li>
                            <li class="nav-item">
                                {{-- <a href="{{ route('admin.blogs.create')}}" class="nav-link" data-key="t-crm"> Thêm </a> --}}
=======
                    <a class="nav-link menu-link" href="#sidebarProduct" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProduct">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Sản Phẩm</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarProduct">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('products.index')}}" class="nav-link" data-key="t-analytics"> Danh sách </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('products.create')}}" class="nav-link" data-key="t-crm"> Thêm </a>
>>>>>>> 7d338e55e99648f0805aef3b86ebbd57123a62fb
                            </li>
                        </ul>
                    </div>
                </li>
<<<<<<< HEAD
                

            </ul>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarBrands" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarBrands">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Brands</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarBrands">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.brands.index') }}" class="nav-link" data-key="t-analytics"> Danh sách </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.brands.create') }}" class="nav-link" data-key="t-crm"> Thêm </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
=======
            
               
            
                <!-- Kích cỡ sản phẩm -->
              
            </ul>
>>>>>>> 7d338e55e99648f0805aef3b86ebbd57123a62fb
            
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
