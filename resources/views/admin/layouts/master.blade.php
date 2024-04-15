<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SB Admin 2 - Dashboard</title>
    <!-- Custom fonts for this template-->
    <link href="/admin/vendor/fontawesome-free/css/all.min.css?ver={{ config('app.version') }}" rel="stylesheet" type="text/css">
    <link
        href="/admin/fonts/font_admin.css?ver={{ config('app.version') }}"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/admin/css/sb_admin_2.min.css?ver={{ config('app.version') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    @stack('styles')
</head>
<body id="page-top">
<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    @include('admin.layouts.sidebar')
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
                @include('admin.layouts.topbar')
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                @yield('content')

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
            @include('admin.layouts.footer')
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>


<!-- Logout Modal-->
@include('admin.layouts.logout_modal')

<script src="https://kit.fontawesome.com/d75eab3bb0.js?ver={{ config('app.version') }}" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10?ver={{ config('app.version') }}"></script>

<!-- Bootstrap core JavaScript-->
<script src="/admin/vendor/jquery/jquery.min.js?ver={{ config('app.version') }}"></script>
<script src="/admin/vendor/bootstrap/js/bootstrap.bundle.min.js?ver={{ config('app.version') }}"></script>

<!-- Core plugin JavaScript-->
<script src="/admin/vendor/jquery-easing/jquery.easing.min.js?ver={{ config('app.version') }}"></script>

<!-- Custom scripts for all pages-->
<script src="/admin/js/sb_admin_2.min.js?ver={{ config('app.version') }}"></script>
@stack('scripts')



</body>

</html>
