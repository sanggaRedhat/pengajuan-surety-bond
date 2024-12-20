<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@include('template.title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <style>
        blockquote { border-left: 0.35rem solid #007bff; }
        .pointer { cursor: pointer; }
        .tableFixHead { overflow: auto; height: 60vh;}
        .tableFixHead thead tr { position: sticky; top: 0; z-index: 1; background-color: #212529; }
        .tableFixHead table { border-collapse: collapse; width: 100%; }
        .table th { padding-top: 5px; padding-bottom: 5px; text-align: center !important; }
        .table td { padding: 5px !important; }
        .btn-logout { margin-top: 1px; }
        hr { margin: 6px 0 !important; }
    </style>
    @stack('css')
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-dark" style="padding: 15px">
            <div class="container">
                <a href="{{ url('/') }}" class="navbar-brand d-flex justify-content-center">
                    <span class="brand-text">@include('template.title')</span>
                </a>
                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav mt-1 ml-3">
                        <li class="nav-item">
                            <a @class(['nav-link', 'active' => request()->segment(2) == null]) href="{{ url('admin') }}">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a @class(['nav-link', 'active' => request()->segment(3) == 'surety-bond']) href="{{ url('admin/manage/surety-bond') }}">
                                Manage SRB
                            </a>
                        </li>
                    </ul>
                    @can('is-admin')
                        <ul class="navbar-nav navbar-no-expand ml-auto">
                            <li class="nav-item dropdown">
                                <a @class(['nav-link pr-0', 'active' => true]) data-toggle="dropdown" href="#" aria-expanded="false">
                                    <i class="far fa-user"></i> | {{ auth()->user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                    <a href="{{ route('pengguna.index') }}" class="dropdown-item dropdown-footer">Pengguna</a>
                                    <div class="dropdown-divider"></div>
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <button id="logout" type="submit" class="dropdown-item dropdown-footer">Keluar</button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    @else
                        <ul class="navbar-nav navbar-no-expand ml-auto">
                            <li class="nav-item">
                                <a class="nav-link pr-0" href="{{ route('pengguna.profil_saya') }}">{{ auth()->user()->name }}</a>
                            </li>
                            <li class="nav-item">
                                <span class="nav-link px-2"> | </span>
                            </li>
                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button id="logout" type="submit" class="btn btn-link btn-logout px-0 text-danger">Keluar</button>
                                </form>
                            </li>
                        </ul>
                    @endcan
                    <!-- Right navbar links -->
                </div>
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            @yield('header')
                        </div><!-- /.col -->
                        <div class="col-sm-6">
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
        $('form[method=POST]').each(function() {
            $(this).submit(function() {
                $('button[type=submit]:not(#logout)').prop('disable', true)
                    .html('<i class="fa fa-spinner fa-pulse mr-1"></i> Proses...')
            });
        });

        function hideMessage(second = 8000) {
            setTimeout(function() {
                $('#alert').hide();
            }, second);
        }

        function successMessage(message) {
            $('#alert').removeClass('alert-danger').addClass('alert-success').html(message).show()
            hideMessage()
        }

        function errorMessage(message) {
            $('#alert').removeClass('alert-success').addClass('alert-danger').html(message).show()
            hideMessage()
        }

        hideMessage()
    </script>
    @stack('script')
</body>
</html>
