@extends('template.index')
@section('header')
    <h1 class="m-0 mt-2">Pengguna</h1>
@endsection
@section('page')
    <div class="row">
        <div class="col-md-12">
            <x-flash-message />
            <div class="row">
                <div class="col-4">
                    <div class="card card-success shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title" id="form-title">Tambah Pengguna</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form name="form">
                                @csrf
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <label>Nama</label>
                                        <input class="form-control @error('name') is-invalid @enderror"
                                        name="name" type="text" value="{{ old('name') }}">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>Email</label>
                                        <input class="form-control @error('email') is-invalid @enderror"
                                            name="email" type="text" value="{{ old('email') }}">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>Password</label>
                                        <input class="form-control @error('password') is-invalid @enderror"
                                            name="password" type="password" value="{{ old('password') }}">
                                        <input name="user_id" type="hidden">
                                    </div>
                                    <div id="btn-action" class="mt-2 w-100 d-flex justify-content-center">
                                        <button type="button" class="btn-save btn btn-primary btn-sm w-50"><i class="fa fa-save mr-1"></i> Simpan</button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </form>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card card-success shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Pengguna</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="dataTable" class="table table-striped table-bordered compact" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th width="5px">No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th width="80px">Aktif</th>
                                        <th width="50px">Akses</th>
                                        <th width="50px">Edit</th>
                                        <th width="50px">Hapus</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    <div class="modal fade" id="modalEditAkses" tabindex="-1" role="dialog" aria-labelledby="modalEditAksesLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modalEditAksesLabel">Edit Role Pengguna</h5>
                    <input id="akses-user_id" type="hidden">
                    <div id="id-btn-update-akses">
                        <button type="button" class="btn-update-akses btn btn-sm btn-primary">
                            Simpan Perubahan
                        </button>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" hidden>
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Role</label>
                        <span class="form-control">
                            <label class="mr-2 font-weight-normal" for="admin">
                                <input id="admin" class="roles" data-role="admin" type="radio" name="role"  value="{{ \App\Models\Role::where('name', 'admin')->first()->id }}"> Admin
                            </label>
                            <label class="mr-2 font-weight-normal" for="manager">
                                <input id="manager" class="roles" data-role="manager" type="radio" name="role"  value="{{ \App\Models\Role::where('name', 'manager')->first()->id }}"> Pengelola
                            </label>
                            <label class="mr-2 font-weight-normal" for="user">
                                <input id="user" class="roles" data-role="user" type="radio" name="role" value="{{ \App\Models\Role::where('name', 'user')->first()->id }}"> Pengguna
                            </label>
                        </span>
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
        $('body').on('click', '.btn-save', function(event){
            if (form.name.value == '' || form.email.value == '' || form.password.value == '') {
                return alert('Data harus diisi.')
            }
            $('.btn-save').prop('disabled', true).html('<i class="fa fa-spinner fa-pulse mr-1"></i> Proses...');
            $.ajax({
                type: "post",
                url: "{{ url('admin/pengguna') }}",
                data: {
                    "_token": form._token.value,
                    "name": form.name.value,
                    "email": form.email.value,
                    "password": form.password.value,
                },
                dataType: "json",
                success: function(response) {
                    hideMessage()
                    $('.btn-save').prop('disabled', false).html('<i class="fa fa-save mr-1"></i> Simpan');
                    if (response.status == true) {
                        $('#alert').removeClass('alert-danger').addClass('alert-success').html(response.message).show()
                        form.name.value = ""
                        form.email.value = ""
                        form.password.value = ""
                        $('#dataTable').DataTable().ajax.reload();
                    } else {
                        $('#alert').removeClass('alert-success').addClass('alert-danger').html(response.message).show()
                    }
                }
            });
        })

        $('body').on('click', '.btn-update', function(event){
            if (form.name.value == '' || form.email.value == '') {
                return alert('Data harus diisi.')
            }
            $('.btn-update').prop('disabled', true).html('<i class="fa fa-spinner fa-pulse mr-1"></i> Proses...');
            $.ajax({
                type: "put",
                url: "{{ url('admin/pengguna') }}/"+form.user_id.value,
                data: {
                    "_token": form._token.value,
                    "name": form.name.value,
                    "email": form.email.value,
                    "password": form.password.value,
                },
                dataType: "json",
                success: function(response) {
                    $('#form-title').html('Tambah Pengguna')
                    form.name.value = ""
                    form.email.value = ""
                    form.password.value = ""
                    form.user_id.value = ""
                    $('#btn-action').html(`
                        <button type="button" class="btn-save btn btn-primary btn-sm w-50"><i class="fa fa-save mr-1"></i> Simpan</button>
                    `)
                    hideMessage()
                    if (response.status == true) {
                        $('#alert').removeClass('alert-danger').addClass('alert-success').html(response.message).show()
                        $('#dataTable').DataTable().ajax.reload();
                    } else {
                        $('#alert').removeClass('alert-success').addClass('alert-danger').html(response.message).show()
                    }
                }
            });
        })

        $(document).ready(function() {
            $('#dataTable').DataTable({
                "aLengthMenu": [
                    [10, 25, 50, 100, 200, -1],
                    [10, 25, 50, 100, 200, "All"]
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
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'is_active',
                        name: 'is_active'
                    },
                    {
                        data: 'edit_akses',
                        name: 'edit_akses',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'edit',
                        name: 'edit',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'hapus',
                        name: 'hapus',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });

        function edit(e,id) {
            $.ajax({
                url: "{{ url('admin/pengguna') }}/"+id,
                dataType: "json",
                success: function(response) {
                    form.name.value = response.data.name
                    form.email.value = response.data.email
                    form.user_id.value = response.data.id
                    $('#form-title').html('Edit Pengguna')
                    $('#btn-action').html(`
                        <button style="width: 40%" type="button" class="btn-batal btn btn-danger btn-sm mr-2"><i class="fa fa-time mr-1"></i> Batal</button>
                        <button style="width: 60%" type="button" class="btn-update btn btn-primary btn-sm"><i class="fa fa-save mr-1"></i> Simpan Perubahan</button>
                    `)
                }
            });
        }

        function editAkses(e,id) {
            $('.roles').prop('checked', false)
            $('#akses-user_id').val(id)
            $.ajax({
                url: "{{ url('admin/pengguna/edit-akses') }}/"+id,
                dataType: "json",
                success: function(response) {
                    $('.roles').each(function(item, data){
                        $(this).prop('checked', data.id == response.role)
                    })
                }
            });
        }

        $('body').on('click', '.btn-update-akses', function() {
            var rolesValue = [];
            $('.roles:checked').each((key, data) => rolesValue.push(data.value))
            $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-pulse mr-1"></i> Proses...');
            $.ajax({
                type: "put",
                url: "{{ url('admin/pengguna/edit-akses') }}/"+$('#akses-user_id').val(),
                data: {
                    "_token": form._token.value,
                    "roles": rolesValue,
                },
                dataType: "json",
                success: function(response) {
                    $('#id-btn-update-akses').html(`
                        <button type="button" class="btn-update-akses btn btn-sm btn-primary"> Simpan Perubahan</button>
                    `)
                    $('#modalEditAkses .close').click()
                    hideMessage()
                    if (response.status == true) {
                        $('#alert').removeClass('alert-danger').addClass('alert-success').html(response.message).show()
                    } else {
                        $('#alert').removeClass('alert-success').addClass('alert-danger').html(response.message).show()
                    }
                }
            });
        })

        $('body').on('click', '.btn-batal', function() {
            $('#form-title').html('Tambah Pengguna')
            form.name.value = ""
            form.email.value = ""
            form.password.value = ""
            form.user_id.value = ""
            $('#btn-action').html(`
                <button type="button" class="btn-save btn btn-primary btn-sm w-50"><i class="fa fa-save mr-1"></i> Simpan</button>
            `)
        })

        function hapus(id) {
            if (confirm("Anda ingin menghapus data?") == true) {
                $.ajax({
                    type: "delete",
                    url: "{{ url('admin/pengguna') }}/"+id,
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(response) {
                        hideMessage()
                        if (response.status == true) {
                            $('#alert').removeClass('alert-danger').addClass('alert-success').html(response.message).show()
                            $('#dataTable').DataTable().ajax.reload();
                        } else {
                            $('#alert').removeClass('alert-success').addClass('alert-danger').html(response.message).show()
                        }
                    }
                });
            }
        }

        function aktifasiPengguna(e,id,aktif) {
            if (confirm(aktif+" pengguna ini?") == true) {
                $(e).prop('disabled', true).html('<i class="fa fa-spinner fa-pulse mr-1"></i>');
                $.ajax({
                    type: "put",
                    url: `{{ url('admin/pengguna/aktif') }}/${id}`,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "aktif": (aktif == 'Aktifkan' ? 1 : 0),
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
    </script>
@endpush
