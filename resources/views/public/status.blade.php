@extends('public.home')

@section('page')
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="mt-3">
                        Tanggal Pengajuan : <span>{{ $suretyBond->created_at->format('d-m-Y') }}</span>
                    </div>
                    <table class="table table-bordered mt-3">
                        <tr class="text-center bg-dark">
                            <th class="py-1">Tanggal</th>
                            <th class="py-1">Status</th>
                            <th class="py-1">Catatan</th>
                        </tr>
                        @php
                            $progres = $suretyBond->progres->last();
                            if ($progres->status == 'Diterima') {
                                $status = 'Terkonfirmasi';
                            } elseif ($progres->status == 'Selesai' || $progres->status == 'Ditolak' || $progres->status == 'Dibatalkan') {
                                $status = $progres->status;
                            } elseif ($progres->status == 'Baru') {
                                $status = 'Diajukan';
                            } else {
                                $status = 'Proses';
                            }
                        @endphp
                        <tr>
                            <td class="py-1">{{ $progres->created_at->format('d-m-Y') }}</td>
                            <td class="py-1">{{ $status }}</td>
                            <td class="py-1">{{ $progres->catatan }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama yang mengajukan</label>
                        <span class="form-control">{{ $suretyBond->nama_pemohon }}</span>
                    </div>
                    <div class="form-group">
                        <label>Jabatan yang mengajukan</label>
                        <span class="form-control">{{ $suretyBond->jabatan_pemohon }}</span>
                    </div>
                    <div class="form-group">
                        <label>Email yang mengajukan</label>
                        <span class="form-control">{{ $suretyBond->email_pemohon }}</span>
                    </div>
                    <div class="form-group">
                        <label>Nomor Telp. / WA yang mengajukan</label>
                        <span class="form-control">{{ $suretyBond->nomor_pemohon }}</span>
                    </div>
                    <div class="form-group">
                        <label>Nama Perusahaan</label>
                        <span class="form-control">{{ $suretyBond->nama_perusahaan }}</span>
                    </div>
                    <div class="form-group">
                        <label>Nama Direktur Perusahaan</label>
                        <span class="form-control">{{ $suretyBond->nama_direktur_perusahaan }}</span>
                    </div>
                    <div class="form-group">
                        <label>Pekerjaan</label>
                        <span class="form-control">{{ $suretyBond->pekerjaan }}</span>
                    </div>
                    <div class="form-group">
                        <label>Nilai Kontrak</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <span class="form-control">{{ NumberFormat::convert($suretyBond->nilai_kontrak) }},-</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 form-group">
                            <label>Nilai Jaminan (Persen)</label>
                            <div class="input-group">
                                <span class="form-control">{{ $suretyBond->nilai_jaminan_persen }}</span>
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>  
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 form-group">
                            <label>Jangka Waktu (Hari)</label>
                            <div class="input-group">
                                <span class="form-control">{{ $suretyBond->jangka_waktu }}</span>
                                <div class="input-group-append">
                                    <span class="input-group-text">Hari</span>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       @if ($suretyBond->progres->last()->status == 'Proses')
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <x-flash-message class="mb-3" />
                    <form action="{{ route('public-home.reupload', $suretyBond->slug) }}" class="mt-3" method="post" enctype="multipart/form-data">
                        @csrf
                        @php $isUpload = false; @endphp
                        <div class="form-group">
                            <label>Berkas Jaminan</label>
                            <span class="form-control">{{ $suretyBond->jenis_berkas_jaminan }} ({{ $suretyBond->berkas_jaminan ? 'Ada' : 'Tidak ada' }})</span>
                        </div>
                        <div class="form-group">
                            <label>Surat Permohonan</label>
                            <span class="form-control">{{ $suretyBond->berkas_permohonan ? 'Ada' : 'Tidak ada' }}</span>
                        </div>
                        <div class="form-group">
                            <label>Surat Pengalaman Pekerjaan</label>
                            @if($suretyBond->berkas_pengalaman_pekerjaan)
                                <span class="form-control">{{ $suretyBond->berkas_pengalaman_pekerjaan ? 'Ada' : 'Tidak ada' }}</span>
                            @else
                                <div class="input-group">
                                    <div class="custom-file">
                                        @php $isUpload = true; @endphp
                                        <input type="file" class="custom-file-input" accept=".zip,.rar,.pdf,.png,.jpg,.jpeg" id="berkas-pengalaman-pekerjaan" name="berkas_pengalaman_pekerjaan">
                                        <label class="custom-file-label" for="berkas-pengalaman-pekerjaan">Choose file...</label>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="mt-5 mb-3">
                            <h5 class="font-weight-bold">Syarat Umum - Badan Usaha</h5>
                        </div>
                        <div class="form-group">
                            <label>Copy Akta Pendirian Perusahaan, berikut perubahannya</label>
                            @if($suretyBond->berkas_umum_1)
                                <span class="form-control">{{ $suretyBond->berkas_umum_1 ? 'Ada' : 'Tidak ada' }}</span>
                            @else
                                <div class="input-group">
                                    <div class="custom-file">
                                        @php $isUpload = true; @endphp
                                        <input type="file" class="custom-file-input" accept=".zip,.rar,.pdf,.png,.jpg,.jpeg" id="berkas-umum-1" name="berkas_umum_1">
                                        <label class="custom-file-label" for="berkas-umum-1">Choose file...</label>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Copy KTP (Kartu Tanda Penduduk)</label>
                            @if($suretyBond->berkas_umum_2)
                                <span class="form-control">{{ $suretyBond->berkas_umum_2 ? 'Ada' : 'Tidak ada' }}</span>
                            @else
                                <div class="input-group">
                                    <div class="custom-file">
                                        @php $isUpload = true; @endphp
                                        <input type="file" class="custom-file-input" accept=".zip,.rar,.pdf,.png,.jpg,.jpeg" id="berkas-umum-2" name="berkas_umum_2">
                                        <label class="custom-file-label" for="berkas-umum-2">Choose file...</label>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Copy Nomor Pokok Wajib Pajak (NPWP)</label>
                            @if($suretyBond->berkas_umum_3)
                                <span class="form-control">{{ $suretyBond->berkas_umum_3 ? 'Ada' : 'Tidak ada' }}</span>
                            @else
                                <div class="input-group">
                                    <div class="custom-file">
                                        @php $isUpload = true; @endphp
                                        <input type="file" class="custom-file-input" accept=".zip,.rar,.pdf,.png,.jpg,.jpeg" id="berkas-umum-3" name="berkas_umum_3">
                                        <label class="custom-file-label" for="berkas-umum-3">Choose file...</label>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Copy Nomor Induk Berusaha (NIB)</label>
                            @if($suretyBond->berkas_umum_4)
                                <span class="form-control">{{ $suretyBond->berkas_umum_4 ? 'Ada' : 'Tidak ada' }}</span>
                            @else
                                <div class="input-group">
                                    <div class="custom-file">
                                        @php $isUpload = true; @endphp
                                        <input type="file" class="custom-file-input" accept=".zip,.rar,.pdf,.png,.jpg,.jpeg" id="berkas-umum-4" name="berkas_umum_4">
                                        <label class="custom-file-label" for="berkas-umum-4">Choose file...</label>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Copy Neraca dan Laba Rugi Principal untuk 2 (dua) tahun terakhir</label>
                            @if($suretyBond->berkas_umum_5)
                                <span class="form-control">{{ $suretyBond->berkas_umum_5 ? 'Ada' : 'Tidak ada' }}</span>
                            @else
                                <div class="input-group">
                                    <div class="custom-file">
                                        @php $isUpload = true; @endphp
                                        <input type="file" class="custom-file-input" accept=".zip,.rar,.pdf,.png,.jpg,.jpeg" id="berkas-umum-5" name="berkas_umum_5">
                                        <label class="custom-file-label" for="berkas-umum-5">Choose file...</label>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="mt-5 mb-3">
                            <h5 class="font-weight-bold">Syarat Khusus - Performance Bond</h5>
                        </div>
                        <div class="form-group">
                            <label>Surat Penunjukan / Penetapan Pengumuman Lelang / Surat Perintah Kerja (SPK) Kontrak Kerja</label>
                            @if($suretyBond->berkas_khusus_1)
                                <span class="form-control">{{ $suretyBond->berkas_khusus_1 ? 'Ada' : 'Tidak ada' }}</span>
                            @else
                                <div class="input-group">
                                    <div class="custom-file">
                                        @php $isUpload = true; @endphp
                                        <input type="file" class="custom-file-input" accept=".zip,.rar,.pdf,.png,.jpg,.jpeg" id="berkas-khusus-1" name="berkas_khusus_1">
                                        <label class="custom-file-label" for="berkas-khusus-1">Choose file...</label>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @if ($isUpload)
                            <div class="form-group pt-4 mb-0 d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary btn-sm px-4 w-50 ml-auto">Kirim Berkas</button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
       @endif
    </div>
@endsection
@push('css')
    <style>
        
    </style>
@endpush
@push('script')

    <script>
        $('form[method=POST]').submit(function() {
            $('button[type=submit]').prop('disable', true).html('Proses, tunggu...')
            $('#modalSpinner').modal({show: true})
        });
    </script>

@endpush
