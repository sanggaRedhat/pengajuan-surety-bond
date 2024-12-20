<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Pengajuan Surety Bond PT. JAMKRIDA KALTENG') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
        .pointer { cursor: pointer; }
        .btn-logout { margin-top: 1px; }
        hr { margin: 6px 0 !important; }
        .btn .caret {
            position: absolute;
            top: calc(50% - 1px);
            right: -12px;
        }
    </style>
    @stack('css')
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light" style="padding: 20px 0;">
            <div class="container d-flex justify-content-center">
                <a class="navbar-brand">
                    <img class="mt-3 mb-2" width="300px" src="{{ asset('assets/img/jamkrida.png') }}" alt="">
                    {{-- <span class="brand-text d-block mt-4 text-center font-weight-bold">PENGAJUAN ONLINE SURETY BOND</span> --}}
                </a>
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container">
                    <div class="row mb-2 mt-2">
                        <div class="col-sm-12 text-center">
                            @yield('header')
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container">
                    @yield('page')
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery-3.7.1.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
    <script>
        function hideMessage(second = 5000) {
            setTimeout(function() {
                $('#alert').hide();
            }, second);
        }

        @if(session('status') == false)
            hideMessage()
        @endif
    </script>
    @stack('script')
</body>

</html>
