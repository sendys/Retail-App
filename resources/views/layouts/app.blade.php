@include('layouts.partials.main')

<head>
    <?php
    $title = 'Dashboard'; ?>

    @include('layouts.partials.title-meta')
    @include('layouts.partials.head-css')
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

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

                    @yield('content')


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

    <!-- Plugins js-->
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/libs/selectize/js/standalone/selectize.min.js') }}"></script>
    <script src="{{ asset('assets/libs/multiselect/js/jquery.multi-select.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/mohithg-switchery/switchery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-mockjax/jquery.mockjax.min.js') }}"></script>
    <script src="{{ asset('assets/libs/devbridge-autocomplete/jquery.autocomplete.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/libs/selectize/js/standalone/selectize.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>

    <script src="{{ asset('assets/libs/jquery-toast-plugin/jquery.toast.min.js') }}"></script>


    <!-- Sweet alert init js-->
    <script src="{{ asset('assets/js/pages/dashboard-1.init.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/pages/sweet-alerts.init.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/pages/toastr.init.js') }}"></script> --}}

</body>

</html>
