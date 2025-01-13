@extends('template.index')
@section('header')
    <h1 class="m-0 mt-2"><small>@include('dashboard.title')</small></h1>
@endsection
@section('page')
    <div class="row d-flex justity-content-center">
        <div class="col-md-12">
            <x-flash-message />
            @if ($pengajuan->count())
                <div class="card card-success shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">Pengajuan Baru</h3>
                        <div class="card-tools">
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="dataTable" class="table table-striped table-bordered compact" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="5px">No</th>
                                    <th>Tiket</th>
                                    <th>Nama Pemohon</th>
                                    <th>Nilai Kontrak</th>
                                    <th width="200px;">Tgl Diajukan</th>
                                    <th width="120px;">Status</th>
                                    <th width="180px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            @else
                <div class="alert alert-danger">
                    Tidak ada pengajuan baru.
                </div>
            @endif
            <div class="card card-success shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Pengajuan Pending Request</h3>
                    <div class="card-tools">
                    </div>
                </div>
                <div class="card-body">
                    <table id="dataTable2" class="table table-striped table-bordered compact" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="5px">No</th>
                                <th>Tiket</th>
                                <th>Nama Pemohon</th>
                                <th>Nilai Kontrak</th>
                                <th width="200px;">Tgl Diajukan</th>
                                <th width="150px;">Status</th>
                                <th width="180px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="card card-success shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Pengajuan dalam Proses</h3>
                    <div class="card-tools">
                    </div>
                </div>
                <div class="card-body">
                    <table id="dataTable3" class="table table-striped table-bordered compact" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="5px">No</th>
                                <th>Tiket</th>
                                <th>Nama Pemohon</th>
                                <th>Nilai Kontrak</th>
                                <th width="200px;">Tgl Diajukan</th>
                                <th width="150px;">Status</th>
                                <th width="150px;">Oleh</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalRequestTo" tabindex="-1" role="dialog" aria-labelledby="modalRequestToLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modalRequestToLabel">Request Pengajuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="srb-id-request"/>
                    <div class="form-group">
                        <select class="form-control custom-select" id="user-id-request">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex mt-3">
                        <button type="button" id="send-request" class="btn btn-sm btn-primary w-50 m-auto">
                            Kirim Pengajuan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <link href="{{ asset('assets/plugins/datatables/datatables.min.css') }}" rel="stylesheet"></link>
@endpush
@push('script')
    <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
    <script>

        $('.btn-refresh').on('click', function(){
            $('#dataTable').DataTable().ajax.reload();
        })

        function modalRequestTo(id) {
            $('#srb-id-request').val(id)
        }

        function confirmRejected(id) {
            if (confirm("Tolak pengajuan?") == true) {
                $.ajax({
                    type: "put",
                    url: `{{ url('admin/manage/surety-bond/rejected') }}/`+id,
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status) {
                            $('#dataTable').DataTable().ajax.reload();
                        }
                    }
                });
            }
        }

        function confirmAccepted(id) {
            if (confirm("Terima pengajuan?") == true) {
                $.ajax({
                    type: "put",
                    url: `{{ url('admin/manage/surety-bond/accepted') }}/`+id,
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status) {
                            $('#dataTable').DataTable().ajax.reload();
                        }
                    }
                });
            }
        }

        function confirmRedirected(id, req_id) {
            if (confirm("Alihkan untuk diproses?") == true) {
                $.ajax({
                    type: "put",
                    url: `{{ url('admin/manage/surety-bond/redirected') }}/`+id,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "req_id": req_id,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status) {
                            $('#dataTable').DataTable().ajax.reload();
                            $('#dataTable2').DataTable().ajax.reload();
                        }
                        @if ($pengajuan->count() == 0)
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        @endif
                    }
                });
            }
        }

        $("#send-request").on('click', function(e) {
            $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-pulse mr-1"></i> Proses...');
            $.ajax({
                type: "post",
                url: `{{ url('admin/manage/surety-bond/request-to') }}`,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "srb_id": $('#srb-id-request').val(),
                    "user_id": $('#user-id-request').val(),
                },
                dataType: "json",
                success: function(response) {
                    $("#send-request").prop('disabled', false).html('Kirim Pengajuan');
                    $('#modalRequestTo .close').click()
                    if (response.status) {
                        $('#dataTable').DataTable().ajax.reload();
                        $('#dataTable2').DataTable().ajax.reload();
                        successMessage(response.message)
                    } else {
                        errorMessage(response.message)
                    }
                }
            });
        })

        $(document).ready(function() {
            $('#dataTable').DataTable({
                "aLengthMenu": [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                paging: true,
                processing: true,
                serverSide: true,
                ajax: '{{ url()->current() }}/pengajuan-baru',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'dt-body-center'
                    },
                    {
                        data: 'no_tiket',
                        name: 'no_tiket'
                    },
                    {
                        data: 'nama_pemohon',
                        name: 'nama_pemohon'
                    },
                    {
                        data: 'nilai_kontrak',
                        name: 'nilai_kontrak',
                        className: 'dt-body-right'
                    },
                    {
                        data: 'tgl_pengajuan',
                        name: 'tgl_pengajuan',
                        className: 'dt-body-center'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'dt-body-center'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        className: 'dt-body-center'
                    },
                ]
            });

            $('#dataTable2').DataTable({
                "aLengthMenu": [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                paging: true,
                processing: true,
                serverSide: true,
                ajax: '{{ url()->current() }}/pengajuan-request',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'dt-body-center'
                    },
                    {
                        data: 'no_tiket',
                        name: 'no_tiket'
                    },
                    {
                        data: 'nama_pemohon',
                        name: 'nama_pemohon'
                    },
                    {
                        data: 'nilai_kontrak',
                        name: 'nilai_kontrak',
                        className: 'dt-body-right'
                    },
                    {
                        data: 'tgl_pengajuan',
                        name: 'tgl_pengajuan',
                        className: 'dt-body-center'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'dt-body-center'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        className: 'dt-body-center'
                    },
                ]
            });

            $('#dataTable3').DataTable({
                "aLengthMenu": [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                paging: true,
                processing: true,
                serverSide: true,
                ajax: '{{ url()->current() }}/pengajuan-proses',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'dt-body-center'
                    },
                    {
                        data: 'no_tiket',
                        name: 'no_tiket'
                    },
                    {
                        data: 'nama_pemohon',
                        name: 'nama_pemohon'
                    },
                    {
                        data: 'nilai_kontrak',
                        name: 'nilai_kontrak',
                        className: 'dt-body-right'
                    },
                    {
                        data: 'tgl_pengajuan',
                        name: 'tgl_pengajuan',
                        className: 'dt-body-center'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'dt-body-center'
                    },
                    {
                        data: 'oleh',
                        name: 'oleh',
                        className: 'dt-body-center'
                    }
                ]
            });
        });
    </script>
@endpush
