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

    <div class="modal fade" id="modalSpinner" tabindex="-1" role="dialog" aria-labelledby="modalSpinnerLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex m-auto" id="modalSpinnerLabel">Sedang Mengirim</h5>
                </div>
                <div class="modal-body">
                    <div class="my-2 pb-1 d-flex justify-content-center">
                        <i class="fa fa-lg fa-spinner fa-pulse mr-1"></i> 
                    </div>
                    <p class="text-center m-0">Mohon tidak keluar jendela browser Anda sampai proses selesai.</p>
                </div>
            </div>
        </div>
    </div>

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

        $('form[method=POST]').submit(function() {
            $('button[type=submit]').prop('disable', true).html('Proses, tunggu...')
            $('#modalSpinner').modal({show: true})
        });

        $('#modalSpinner').modal({backdrop: 'static', keyboard: true, show: false})

        $(document).on('change', '.custom-file-input', function (event) {
            $(this).next('.custom-file-label').html(event.target.files[0].name);
            
            var val = $(this).val().toLowerCase(),
            regex = new RegExp("(.*?)\.(zip|rar|pdf|png|jpg|jpeg)$");

            if (!(regex.test(val))) {
                $(this).next('.custom-file-label').html('Choose file...');
                return alert('Format file yang Anda masukkan tidak valid.');
            }

            const fileSize = event.target.files[0].size / 1024 / 1024;
            if (fileSize > 50) {
                $(this).next('.custom-file-label').html('Choose file...');
                return alert('Ukuran file melebihi batas yang diizinkan, maks 50 MB.');
            }
        })
    </script>
    @stack('script')
</body>

</html>
