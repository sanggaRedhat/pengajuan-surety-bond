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
                    <x-flash-message class="mb-3" />
                    <form class="mt-1">
                        @csrf
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
                        <div class="form-group">
                            <label>Jenis Penjaminan</label>
                            <span class="form-control">{{ $suretyBond->jenis_penjaminan }}</span>
                        </div>
                        <div class="form-group">
                            <label class="mb-1">Berkas Jaminan</label>
                            <span class="form-control">{{ $suretyBond->jenis_berkas_jaminan }} ({{ $suretyBond->berkas_jaminan ? 'Ada' : 'Tidak ada' }})</span>
                        </div>
                        <div class="form-group">
                            <label class="mb-1">Surat Permohonan</label>
                            <span class="form-control">{{ $suretyBond->berkas_permohonan ? 'Ada' : 'Tidak ada' }}</span>
                        </div>
                        <div class="form-group">
                            <label class="mb-1">Surat Pengalaman Pekerjaan</label>
                            <span class="form-control">{{ $suretyBond->berkas_pengalaman_pekerjaan ? 'Ada' : 'Tidak ada' }}</span>
                        </div>
                        <div class="mt-5 mb-3">
                            <h5 class="font-weight-bold">Syarat Umum - Badan Usaha</h5>
                        </div>
                        <div class="form-group">
                            <label>Copy Akta Pendirian Perusahaan, berikut perubahannya</label>
                            <span class="form-control">{{ $suretyBond->berkas_umum_1 ? 'Ada' : 'Tidak ada' }}</span>
                        </div>
                        <div class="form-group">
                            <label>Copy KTP (Kartu Tanda Penduduk)</label>
                            <span class="form-control">{{ $suretyBond->berkas_umum_2 ? 'Ada' : 'Tidak ada' }}</span>
                        </div>
                        <div class="form-group">
                            <label>Copy Nomor Pokok Wajib Pajak (NPWP)</label>
                            <span class="form-control">{{ $suretyBond->berkas_umum_3 ? 'Ada' : 'Tidak ada' }}</span>
                        </div>
                        <div class="form-group">
                            <label>Copy Nomor Induk Berusaha (NIB)</label>
                            <span class="form-control">{{ $suretyBond->berkas_umum_4 ? 'Ada' : 'Tidak ada' }}</span>
                        </div>
                        <div class="form-group">
                            <label>Surat Keterangan Domisili</label>
                            <span class="form-control">{{ $suretyBond->berkas_umum_5 ? 'Ada' : 'Tidak ada' }}</span>
                        </div>
                        <div class="form-group">
                            <label>Copy Neraca dan Laba Rugi Principal untuk 2 (dua) tahun terakhir</label>
                            <span class="form-control">{{ $suretyBond->berkas_umum_6 ? 'Ada' : 'Tidak ada' }}</span>
                        </div>
                        <div class="mt-5 mb-3">
                            <h5 class="font-weight-bold">Syarat Umum - Perorangan</h5>
                        </div>
                        <div class="form-group">
                            <label>Copy KTP (Kartu Tanda Penduduk)</label>
                            <span class="form-control">{{ $suretyBond->berkas_perorangan_1 ? 'Ada' : 'Tidak ada' }}</span>
                        </div>
                        <div class="form-group">
                            <label>Copy Nomor Pokok Wajib Pajak (NPWP)</label>
                            <span class="form-control">{{ $suretyBond->berkas_perorangan_2 ? 'Ada' : 'Tidak ada' }}</span>
                        </div>
                        <div class="form-group">
                            <label>Surat Keterangan Domisili</label>
                            <span class="form-control">{{ $suretyBond->berkas_perorangan_3 ? 'Ada' : 'Tidak ada' }}</span>
                        </div>
                        <div class="mt-5 mb-3">
                            <h5 class="font-weight-bold">Syarat Khusus - Performance Bond</h5>
                        </div>
                        <div class="form-group">
                            <label>Surat Penunjukan / Penetapan Pengumuman Lelang / Surat Perintah Kerja (SPK) Kontrak Kerja</label>
                            <span class="form-control">{{ $suretyBond->berkas_khusus_1 ? 'Ada' : 'Tidak ada' }}</span>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
@endsection
@push('css')
    <style>
        
    </style>
@endpush
@push('script')

@endpush
