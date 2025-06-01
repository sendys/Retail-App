@include('layouts.partials.main')

<head>
    <?php
    $title = 'Error Page | 404 | Page not Found'; ?>

    @include('layouts.partials.title-meta')
    @include('layouts.partials.head-css')

</head>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        @include('layouts.partials.menu')

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">

            @include('layouts.partials.topbar')

            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-xl-4 mb-4">
                            <div class="error-text-box">

                                <img src="{{ asset('assets/images/not-found.png') }}" alt="" class="img-fluid" />
                            </div>
                            <div class="text-center">
                                <h3 class="mt-0 mb-2">Whoops! Akses Ditolak </h3>
                                <p class="text-muted mb-3">Page Error 404. Anda tidak bisa untuk mengakses menu ini,
                                    aplikasi akan mengecek
                                    permission setiap anda membuka. Jika anda mengalami kesulitan, silakan hubungi
                                    admin.
                                </p>

                                <a href="{{ route('home') }}" class="btn btn-success waves-effect waves-light">Back to
                                    Dashboard</a>
                            </div>
                            <!-- end row -->

                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->


                </div> <!-- container -->

            </div> <!-- content -->

            @include('layouts.partials.footer')

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    @include('layouts.partials.right-sidebar')
    @include('layouts.partials.footer-scripts')

</body>

</html>
