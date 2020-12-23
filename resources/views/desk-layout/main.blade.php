<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/assets-template/img/64px-Apache_kafka-icon.svg.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets-template/img/32px-Apache_kafka-icon.svg.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets-template/css/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="/assets-template/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <!--<link rel="stylesheet" href="/assets-template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">-->
    <!-- JQVMap -->
    <!--<link rel="stylesheet" href="/assets-template/plugins/jqvmap/jqvmap.min.css">-->
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets-template/css/adminlte.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="/assets-template/css/select2.min.css">
    <link rel="stylesheet" href="/assets-template/css/select2-bootstrap4.min.css">
    <!-- daterange picker -->
    <!--<link rel="stylesheet" href="/assets-template/plugins/daterangepicker/daterangepicker.css">-->
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/assets-template/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <!--<link rel="stylesheet" href="/assets-template/plugins/daterangepicker/daterangepicker.css">-->
    <link rel="stylesheet" href="/assets-template/css/bootstrap-datepicker-1.8.0.min.css">
    <!-- summernote -->
    <!--<link rel="stylesheet" href="/assets-template/plugins/summernote/summernote-bs4.css">-->
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="/assets-template/css/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="/assets-template/toastr/toastr.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="/assets-template/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets-template/css/responsive.bootstrap4.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    @livewireStyles
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('sweetalert::alert')

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>


            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">welcome, <strong>{{ Auth::user()->name }}</strong></a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">@yield('subtitle')</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">@yield('subtitle')</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- /.this is sidebar -->
            @include('desk-layout.sidebar')

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- this is content -->
                    @yield('content')
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2020<?= (date('Y') > 2019 ? ' - ' . date('Y') : '') ?> | RajaRenov | </strong> All rights
            reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="/assets-template/js/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/assets-template/js/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="/assets-template/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <!--<script src="/assets-template/plugins/chart.js/Chart.min.js"></script>-->
    <!-- Sparkline -->
    <!--<script src="/assets-template/plugins/sparklines/sparkline.js"></script>-->
    <!-- JQVMap -->
    <!--<script src="/assets-template/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="/assets-template/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>-->
    <!-- jQuery Knob Chart -->
    <!--<script src="/assets-template/plugins/jquery-knob/jquery.knob.min.js"></script>-->
    <!-- daterangepicker -->
    <!--<script src="/assets-template/plugins/moment/moment.min.js"></script>
    <script src="/assets-template/plugins/daterangepicker/daterangepicker.js"></script>-->
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="/assets-template/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <!--<script src="/assets-template/plugins/summernote/summernote-bs4.min.js"></script>-->
    <!-- overlayScrollbars -->
    <script src="/assets-template/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/assets-template/js/adminlte.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!--<script src="/assets-template/dist/js/pages/dashboard.js"></script>-->
    <!-- AdminLTE for demo purposes -->
    <!--<script src="/assets-template/dist/js/demo.js"></script>-->
    <!-- Select2 -->
    <script src="/assets-template/js/select2.full.min.js"></script>
    <!-- date-range-picker -->
    <!--<script src="/assets-template/plugins/daterangepicker/daterangepicker.js"></script>-->
    <!-- ChartJS -->
    <!--<script src="/assets-template/plugins/chart.js/Chart.min.js"></script>-->
    <!-- bs-custom-file-input -->
    <script src="/assets-template/js/bs-custom-file-input.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="/assets-template/js/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="/assets-template/toastr/toastr.min.js"></script>
    <script src="/assets-template/js/bootstrap-datepicker-1.8.0.min.js"></script>
    <script src="/assets-template/js/2.0.0-autoNumeric.min.js" type="text/javascript"></script>
    <!-- DataTables -->
    <script src="/assets-template/js/jquery.dataTables.min.js"></script>
    <script src="/assets-template/js/dataTables.bootstrap4.min.js"></script>
    <!--<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>-->

    <!-- <script>
        window.livewire.on('alert', param => {
            toastr[param['type']](param['message'], param['type']);
        });
    </script> -->

    <script type="text/javascript">
        $(document).ready(function() {
            bsCustomFileInput.init();
        });
    </script>
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

    <script type="text/javascript">
        jQuery(function($) {
            //$('#txt_tot_outstanding').autoNumeric('init'); 
            $('#nominal_debit').autoNumeric('init', {
                vMin: '0',
                vMax: '999999999999999'
            });
        });
    </script>
    <script type="text/javascript">
        jQuery(function($) {
            //$('#txt_tot_outstanding').autoNumeric('init'); 
            $('#nominal_credit').autoNumeric('init', {
                vMin: '0',
                vMax: '999999999999999'
            });
        });
    </script>
    <script>
        $('.date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        })
    </script>
    <script>
        window.livewire.on('alert', param => {
            toastr[param['type']](param['message'], param['type']);
        });
    </script>



    @livewireScripts
</body>

</html>