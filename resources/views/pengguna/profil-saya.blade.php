@extends('template.index')
@section('header')
    <h1 class="m-0 mt-2"></h1>
@endsection
@section('page')
    <div class="row">
        <div class="col-md-12">
            <div class="row justify-content-center">
                <div class="col-12 col-md-4">
                    <div class="card card-success shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title" id="form-title">Profil Saya</h3>
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
                                <div class="form-group">
                                    <label>Nama</label>
                                    <span class="form-control" @readonly(true)>{{ auth()->user()->name }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <span class="form-control" @readonly(true)>{{ auth()->user()->email }}</span>
                                </div>
                                <hr class="my-4">
                                <x-flash-message class="mb-3" />
                                <div class="form-group">
                                    <label>Password Lama</label>
                                    <input type="password" class="form-control" name="current_password">
                                </div>
                                <div class="form-group">
                                    <label>Password Baru</label>
                                    <input type="password" class="form-control" name="new_password">
                                </div>
                                <div id="btn-action" class="mt-4 w-100 d-flex justify-content-center">
                                    <button type="button" class="btn-update btn btn-primary btn-block"><i class="fa fa-save mr-1"></i> Update Password</button>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
@push('css')
    <link href="{{ asset('assets/plugins/datatables/datatables.min.css') }}" rel="stylesheet"></link>
@endpush
@push('script')
    <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
    <script>
        $('body').on('click', '.btn-update', function(event){
            if (form.current_password.value == '' || form.new_password.value == '') {
                return alert('Password harus diisi.')
            }
            $('.btn-update').prop('disabled', true).html('<i class="fa fa-spinner fa-pulse mr-1"></i> Proses...');
            $.ajax({
                type: "post",
                url: "{{ route('pengguna.update_password') }}",
                data: {
                    "_token": form._token.value,
                    "current_password": form.current_password.value,
                    "new_password": form.new_password.value,
                },
                dataType: "json",
                success: function(response) {
                    form.current_password.value = ""
                    form.new_password.value = ""
                    $('#btn-action').html(`
                        <button type="button" class="btn-update btn btn-primary btn-block"><i class="fa fa-save mr-1"></i> Update Password</button>
                    `)

                    if (response.status == true) {
                        successMessage(response.message)
                        setTimeout(function() {
                            location.reload()
                        }, 1500);
                    } else {
                        errorMessage(response.message)
                    }
                }
            });
        })
    </script>
@endpush
