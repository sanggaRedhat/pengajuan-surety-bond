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
                            <button type="button" class="btn btn-tool btn-refresh"><i class="fa fa-redo"></i></button>
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
                                    <th width="150px;">Status</th>
                                    <th width="150px;">Aksi</th>
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

        $(document).ready(function() {
            $('#dataTable').DataTable({
                "aLengthMenu": [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                paging: true,
                processing: true,
                serverSide: true,
                ajax: '{{ url()->current() }}',
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
        });
    </script>
@endpush
