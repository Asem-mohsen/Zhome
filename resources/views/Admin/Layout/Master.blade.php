@include('Admin.Layout.header.head')

        <div class="wrapper">

            @include('Admin.Layout.preloader.preloader')

            @include('Admin.Layout.navbar.navbar')

            @include('Admin.Layout.sidebar.sidebar')

            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                  <div class="container-fluid">
                    <div class="row mb-2">
                      <div class="col-sm-6">
                        <h1 class="m-0">@yield('Title')</h1>
                      </div>
                      <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="#">Home</a></li>
                          <li class="breadcrumb-item active">@yield('Title')</li>
                        </ol>
                      </div>
                    </div>
                  </div>
                </div>
                <section class="content">
                    <div class="container-fluid">
                        @yield('Content')
                    </div>
                </section>
            </div>

            <aside class="control-sidebar control-sidebar-dark">
            </aside>
        </div>


    @include('Admin.Layout.footer.footer')