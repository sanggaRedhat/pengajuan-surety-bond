@extends('public.home')

@section('page')
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-lg-center mt-3 mb-4 font-weight-bold">PENGAJUAN SURETY BOND</h4>
                    <div class="mb-3">
                        <p class="m-0 font-weight-bold">PT. JAMKRIDA KALTENG</p>
                        <p class="m-0">Jl. Tjilik Riwut KM.1, Palangka Raya, 73111</p>
                        <p class="m-0">
                            <span>Telphone : <a href="tel:05363239222">(0536) 3239222</a></span><span class="d-none d-lg-inline">;</span>
                            <span class="d-lg-inline d-block">Handphone (WA) : <a href="https://wa.me/+6282159832667?text=Tanya [Surety Bond] :%20" target="_blank">+6282159832667</a></span>
                        </p>
                        <p class="m-0">E-mail : <a href="mailto:bisnis.jamkridakalteng@yahoo.com?subject=Tanya [Surety Bond]&cc=pengajuan.jamkridakalteng@gmail.com" target="_blank">bisnis.jamkridakalteng@yahoo.com</a></p>
                    </div>
                </div>
                <div class="card-body">
                    <x-flash-message class="mb-3" />
                    @if (session()->has('status') == false || session()->get('status') == false)
                        <div style="font-size: 13.5px">
                            <span class="text-danger">- * Inputan wajib diisi.</span>
                            <span class="text-danger d-block">- Format file : zip, rar, pdf, jpeg, jpg, png; Maks 50 MB.</span>
                        </div>
                        <form action="{{ route('public-home.sendRequest') }}" class="mt-3" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Nama yang mengajukan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_pemohon" value="{{ old('nama_pemohon') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Jabatan yang mengajukan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="jabatan_pemohon" value="{{ old('jabatan_pemohon') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Email yang mengajukan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="email" value="{{ old('email') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Nomor Telp. / WA yang mengajukan <span class="text-danger">*</span></label>
                                <input type="number" class="number form-control" name="nomor_pemohon" value="{{ old('nomor_pemohon') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Nama Perusahaan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_perusahaan" value="{{ old('nama_perusahaan') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Nama Direktur Perusahaan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_direktur_perusahaan" value="{{ old('nama_direktur_perusahaan') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Pekerjaan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="pekerjaan" value="{{ old('pekerjaan') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Nilai Kontrak <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp.</span>
                                    </div>
                                    <input type="text" class="form-control currency" name="nilai_kontrak" value="{{ old('nilai_kontrak') }}" maxlength="17" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12 form-group">
                                    <label>Nilai Jaminan (Persen) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control persen" name="nilai_jaminan_persen" value="{{ old('nilai_jaminan_persen') }}" maxlength="3" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>  
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 form-group">
                                    <label>Jangka Waktu (Hari) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control days" name="jangka_waktu" value="{{ old('jangka_waktu') }}" maxlength="3" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Hari</span>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Jenis Penjaminan <span class="text-danger">*</span></label>
                                <input type="hidden" class="form-control" name="jenis_berkas_jaminan" id="jenis-berkas-jaminan" value="{{ old('jenis_berkas_jaminan') }}" required>
                                <select class="form-control custom-select" name="jenis_penjaminan" id="jenis-penjaminan" required>
                                    <option value="">-- Pilih Jenis Jaminan --</option>
                                    <option value="Jaminan Penawaran">Jaminan Penawaran</option>
                                    <option value="Jaminan Pelaksanaan">Jaminan Pelaksanaan</option>
                                    <option value="Jaminan Uang Muka">Jaminan Uang Muka</option>
                                    <option value="Jaminan Pemeliharaan">Jaminan Pemeliharaan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="mb-1">Upload Berkas Jaminan <span class="text-danger">*</span></label>
                                <div class="mb-2">
                                    <span id="text-berkas-jenis-jaminan" class="font-weight-bold text-sm font-italic">- </span>
                                </div>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" accept=".zip,.rar,.pdf,.png,.jpg,.jpeg" id="berkas-jaminan" name="berkas_jaminan" disabled required>
                                        <label class="custom-file-label" for="berkas-jaminan">Choose file...</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="mb-1">Surat Permohonan <span class="text-danger">*</span></label>
                                <div class="mb-2">
                                    <span class="font-weight-bold text-sm font-italic">- <a href="https://drive.google.com/file/d/1Qbf4oTSWRCiBKXBt59GYV9R205KzOJ4b/view?usp=drive_link" target="_blank"><u>Download surat permohonan disini.</u></a></span>
                                </div>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" accept=".zip,.rar,.pdf,.png,.jpg,.jpeg" id="berkas-permohonan" name="berkas_permohonan" required>
                                        <label class="custom-file-label" for="berkas-permohonan">Choose file...</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="mb-1">Surat Pengalaman Pekerjaan </label>
                                <div class="mb-2">
                                    <span class="font-weight-bold text-sm font-italic">- Minimal 3 pekerjaan yang sudah diselesaikan.</span>
                                </div>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" accept=".zip,.rar,.pdf,.png,.jpg,.jpeg" id="berkas-pengalaman-pekerjaan" name="berkas_pengalaman_pekerjaan">
                                        <label class="custom-file-label" for="berkas-pengalaman-pekerjaan">Choose file...</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 mb-3">
                                <h5 class="font-weight-bold">Syarat Umum - Badan Usaha</h5>
                            </div>
                            <div class="form-group">
                                <label>Copy Akta Pendirian Perusahaan, berikut perubahannya </label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" accept=".zip,.rar,.pdf,.png,.jpg,.jpeg" id="berkas-umum-1" name="berkas_umum_1">
                                        <label class="custom-file-label" for="berkas-umum-1">Choose file...</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Copy KTP (Kartu Tanda Penduduk) </label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" accept=".zip,.rar,.pdf,.png,.jpg,.jpeg" id="berkas-umum-2" name="berkas_umum_2">
                                        <label class="custom-file-label" for="berkas-umum-2">Choose file...</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Copy Nomor Pokok Wajib Pajak (NPWP) </label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" accept=".zip,.rar,.pdf,.png,.jpg,.jpeg" id="berkas-umum-3" name="berkas_umum_3">
                                        <label class="custom-file-label" for="berkas-umum-3">Choose file...</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Copy Nomor Induk Berusaha (NIB) </label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" accept=".zip,.rar,.pdf,.png,.jpg,.jpeg" id="berkas-umum-4" name="berkas_umum_4">
                                        <label class="custom-file-label" for="berkas-umum-4">Choose file...</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Copy Neraca dan Laba Rugi Principal untuk 2 (dua) tahun terakhir </label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" accept=".zip,.rar,.pdf,.png,.jpg,.jpeg" id="berkas-umum-5" name="berkas_umum_5">
                                        <label class="custom-file-label" for="berkas-umum-5">Choose file...</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 mb-3">
                                <h5 class="font-weight-bold">Syarat Khusus - Performance Bond</h5>
                            </div>
                            <div class="form-group">
                                <label>Surat Penunjukan / Penetapan Pengumuman Lelang / Surat Perintah Kerja (SPK) Kontrak Kerja </label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" accept=".zip,.rar,.pdf,.png,.jpg,.jpeg" id="berkas-khusus-1" name="berkas_khusus_1">
                                        <label class="custom-file-label" for="berkas-khusus-1">Choose file...</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group pt-4 mb-0 d-flex justify-content-between">
                                <input type="reset" class="btn btn-link text-danger btn-sm pl-0 mr-1" value="Kosongkan Form">
                                <button type="submit" class="btn btn-primary btn-sm px-4 w-50">Kirim Pengajuan</button>
                            </div>
                        </form>
                    @else
                        <div class="mt-4">
                            <p class="text-danger font-weight-bold">Klik tombol di bawah ini untuk konfirmasi pengajuan anda.</p>
                            <a class="btn btn-info btn-sm" href="https://wa.me/+6282159832667?text=Nomor Tiket : {{ session('data_pengajuan')['no_tiket'] }}%0A%0ANama yang mengajukan : {{ session('data_pengajuan')['nama_pemohon'] }}%0APerusahaan : {{ session('data_pengajuan')['nama_perusahaan'] }}%0AJenis Penjaminan : {{ session('data_pengajuan')['jenis_penjaminan'] }}%0ANilai Kontrak : {{ IDRCurrency::convert(session('data_pengajuan')['nilai_kontrak'], true) }}%0APekerjaan : {{ session('data_pengajuan')['pekerjaan'] }}%0ATanggal Pengajuan : {{ IDDateFormat::convert(session('data_pengajuan')['created_at'], true) }}%0A%0ABahwa data pengajuan di atas benar adanya.%0A{{ url()->route('public-home.status', session('data_pengajuan')['slug']) }}">Kirim Konfirmasi</a>
                        </div>
                        <div class="mt-3">
                            <div class="form-group">
                                <label>Nama yang mengajukan</label>
                                <span class="form-control">{{ session('data_pengajuan')['nama_pemohon'] }}</span>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <span class="form-control">{{ session('data_pengajuan')['email_pemohon'] }}</span>
                            </div>
                            <div class="form-group">
                                <label>Nomor Telp. / WA Pemohon</label>
                                <span class="form-control">{{ session('data_pengajuan')['nomor_pemohon'] }}</span>
                            </div>
                            <div class="form-group">
                                <label>Nama Perusahaan</label>
                                <span class="form-control">{{ session('data_pengajuan')['nama_perusahaan'] }}</span>

                            </div>
                            <div class="form-group">
                                <label>Pekerjaan</label>
                                <span class="form-control">{{ session('data_pengajuan')['pekerjaan'] }}</span>
                            </div>
                            <div class="form-group">
                                <label>Nilai Kontrak</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp.</span>
                                    </div>
                                    <span class="form-control">{{ NumberFormat::convert(session('data_pengajuan')['nilai_kontrak']) }},-</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12 form-group">
                                    <label>Nilai Jaminan (Persen)</label>
                                    <div class="input-group">
                                        <span class="form-control">{{ session('data_pengajuan')['nilai_jaminan_persen'] }}</span>
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>  
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 form-group">
                                    <label>Jangka Waktu (Hari)</label>
                                    <div class="input-group">
                                        <span class="form-control">{{ session('data_pengajuan')['jangka_waktu'] }}</span>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Hari</span>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Jenis Penjaminan</label>
                                <span class="form-control">{{ session('data_pengajuan')['jenis_penjaminan'] }}</span>
                            </div>
                         </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <style>
        .custom-file-label, .custom-file-label::after {
            padding-top: 5px !important;
        }
    </style>
@endpush
@push('script')
    <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('assets/is-number.js') }}"></script>
    <script>
        initNumber($('.number'))

        $(".currency").inputmask({
            alias: 'decimal',
            groupSeparator: ',',
            digits: 2,
            min: 0,
            autoGroup: true,
            allowMinus: false,
            removeMaskOnSubmit: true
        });

        $(".persen").inputmask({
            alias: 'integer',
            min: 0,
            max: 100,
            autoGroup: true,
            allowMinus: false,
            removeMaskOnSubmit: true
        });

        $(".days").inputmask({
            alias: 'integer',
            min: 0,
            max: 999,
            autoGroup: true,
            allowMinus: false,
            removeMaskOnSubmit: true
        });

        $(document).on('click', 'input[type=reset]', function (event) {
            $('.custom-file-label').html('Choose file...');
            $('#text-berkas-jenis-jaminan').html('-')
            $('#jenis-berkas-jaminan').val('')
            return $('#berkas-jaminan').prop('disabled', true)
        })

        $(document).on('change', '#jenis-penjaminan', function (event) {
            if($(this).val() == "") {
                $('#text-berkas-jenis-jaminan').html('-')
                $('#jenis-berkas-jaminan').val('')
                return $('#berkas-jaminan').prop('disabled', true)
            } else {
                $('#berkas-jaminan').prop('disabled', false)
                if($(this).val() == "Jaminan Penawaran") {
                    $('#text-berkas-jenis-jaminan').html('- Dokumen Lelang')
                    $('#jenis-berkas-jaminan').val('Dokumen Lelang')
                } else if($(this).val() == "Jaminan Pelaksanaan") {
                    $('#text-berkas-jenis-jaminan').html('- SPPBJ / SPMK')
                    $('#jenis-berkas-jaminan').val('SPPBJ / SPMK')
                } else if($(this).val() == "Jaminan Uang Muka") {
                    $('#text-berkas-jenis-jaminan').html('- Kontrak / SP / SPK')
                    $('#jenis-berkas-jaminan').val('Kontrak / SP / SPK')
                } else if($(this).val() == "Jaminan Pemeliharaan") {
                    $('#text-berkas-jenis-jaminan').html('- Berita Acara Serah Terima Pekerjaan 95% / 100%')
                    $('#jenis-berkas-jaminan').val('Berita Acara Serah Terima Pekerjaan 95% / 100%')
                }
            }

        })
    </script>
@endpush
