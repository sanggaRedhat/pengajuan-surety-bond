@extends('template.index')
@section('header')
    <h1 class="m-0 mt-2">{{ $suretyBond->nama_perusahaan }}</h1>
@endsection
@section('page')
    <div class="row">
        <div class="col-md-12">
            <x-flash-message />
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card card-success shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Detail dan Berkas Pengajuan</h3>
                            <div class="float-right d-print-none">
                                <a href="{{ route('surety-bond.index')}}" class="btn btn-sm btn-dark"><i class="fa fa-arrow-left mr-1"></i> Kembali</a>
                                <button type="button" class="btn btn-sm btn-dark" onclick="window.print()"><i class="fa fa-print mr-1"></i> Cetak</button>
                                @if ($suretyBond->progres->last()->user_id == auth()->id() 
                                    || ($suretyBond->progres->last()->user_id == null 
                                        && collect($suretyBond->progres)[$suretyBond->progres->count()-2]->user_id == auth()->id()
                                    )
                                )
                                    @if ($suretyBond->status == 'Proses')
                                        <a href="#" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#modalCatatan"><i class="fa fa-file mr-1"></i> Update Progres</a>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <table class="w-100">
                                        <tr>
                                            <td width="35%">No. Tiket</td>
                                            <td width="10px">:</td>
                                            <td>{{ $suretyBond->no_tiket }}</td>
                                        </tr>
                                        <tr>
                                            <td width="35%">Nama</td>
                                            <td width="10px">:</td>
                                            <td>{{ $suretyBond->nama_pemohon }}</td>
                                        </tr>
                                        <tr>
                                            <td width="35%">Jabatan</td>
                                            <td width="10px">:</td>
                                            <td>{{ $suretyBond->jabatan_pemohon }}</td>
                                        </tr>
                                        <tr>
                                            <td width="35%">Nomor</td>
                                            <td width="10px">:</td>
                                            <td>{{ $suretyBond->nomor_pemohon }}</td>
                                        </tr>
                                        <tr>
                                            <td width="35%">Email</td>
                                            <td width="10px">:</td>
                                            <td>{{ $suretyBond->email_pemohon }}</td>
                                        </tr>
                                        <tr>
                                            <td width="35%"></td>
                                            <td width="10px"></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width="35%">Tanggal Pengajuan</td>
                                            <td width="10px">:</td>
                                            <td>{{ IDDateFormat::convert($suretyBond->created_at, true) }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col">
                                    <table class="w-100">
                                        <tr>
                                            <td width="35%">Perusahaan</td>
                                            <td width="10px">:</td>
                                            <td>{{ $suretyBond->nama_perusahaan }}</td>
                                        </tr>
                                        <tr>
                                            <td width="35%">Nama Direktur</td>
                                            <td width="10px">:</td>
                                            <td>{{ $suretyBond->nama_direktur_perusahaan }}</td>
                                        </tr>
                                        <tr>
                                            <td width="35%">Pekerjaan</td>
                                            <td width="10px">:</td>
                                            <td>{{ $suretyBond->pekerjaan }}</td>
                                        </tr>
                                        <tr>
                                            <td width="35%">Nilai Kontrak</td>
                                            <td width="10px">:</td>
                                            <td>Rp. {{ NumberFormat::convert($suretyBond->nilai_kontrak) }},-</td>
                                        </tr>
                                        <tr>
                                            <td width="35%">Nilai Jaminan</td>
                                            <td width="10px">:</td>
                                            <td>Rp. {{ NumberFormat::convert($suretyBond->nilai_kontrak*$suretyBond->nilai_jaminan_persen/100) }},- ({{ $suretyBond->nilai_jaminan_persen }}%)</td>
                                        </tr>
                                        <tr>
                                            <td width="35%">Jangka Waktu</td>
                                            <td width="10px">:</td>
                                            <td>{{ $suretyBond->jangka_waktu }} Hari</td>
                                        </tr>
                                        <tr>
                                            <td width="35%">Jenis Jaminan</td>
                                            <td width="10px">:</td>
                                            <td>{{ $suretyBond->jenis_penjaminan }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <div class="row" style="font-size: 14.5px">
                                <div class="col">
                                    <table class="w-100">
                                        <tr>
                                            <td width="85%" colspan="2">Berkas Jaminan</td>
                                            <td width="10px"></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td width="10px">-</td>
                                            <td width="85%">{{ $suretyBond->jenis_berkas_jaminan }}</td>
                                            <td width="10px">:</td>
                                            <td><x-btn-lihat-berkas file="{{ $suretyBond->berkas_jaminan }}" /></td>
                                        </tr>
                                        <tr>
                                            <td width="85%" colspan="2">Surat Permohonan</td>
                                            <td width="10px">:</td>
                                            <td><x-btn-lihat-berkas file="{{ $suretyBond->berkas_permohonan }}" /></td>
                                        </tr>
                                        <tr>
                                            <td width="85%" colspan="2">Surat Pengalaman Pekerjaan</td>
                                            <td width="10px">:</td>
                                            <td><x-btn-lihat-berkas file="{{ $suretyBond->berkas_pengalaman_pekerjaan }}" /></td>
                                        </tr>
                                        <tr>
                                            <td width="85%" colspan="2"><b>Syarat Umum - Badan Usaha</b></td>
                                            <td width="10px"></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td width="10px">-</td>
                                            <td width="85%">Copy Akta Pendirian Perusahaan, berikut perubahannya</td>
                                            <td width="10px">:</td>
                                            <td><x-btn-lihat-berkas file="{{ $suretyBond->berkas_umum_1 }}" /></td>
                                        </tr>
                                        <tr>
                                            <td width="10px">-</td>
                                            <td width="85%">Copy KTP (Kartu Tanda Penduduk)</td>
                                            <td width="10px">:</td>
                                            <td><x-btn-lihat-berkas file="{{ $suretyBond->berkas_umum_2 }}" /></td>
                                        </tr>
                                        <tr>
                                            <td width="10px">-</td>
                                            <td width="85%">Copy Nomor Pokok Wajib Pajak (NPWP)</td>
                                            <td width="10px">:</td>
                                            <td><x-btn-lihat-berkas file="{{ $suretyBond->berkas_umum_3 }}" /></td>
                                        </tr>
                                        <tr>
                                            <td width="10px">-</td>
                                            <td width="85%">Copy Nomor Induk Berusaha (NIB)</td>
                                            <td width="10px">:</td>
                                            <td><x-btn-lihat-berkas file="{{ $suretyBond->berkas_umum_4 }}" /></td>
                                        </tr>
                                        <tr>
                                            <td width="10px">-</td>
                                            <td width="85%">Copy Neraca dan Laba Rugi Principal untuk 2 (dua) tahun terakhir</td>
                                            <td width="10px">:</td>
                                            <td><x-btn-lihat-berkas file="{{ $suretyBond->berkas_umum_5 }}" /></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col">
                                    <table class="w-100">
                                        <tr>
                                            <td width=""></td>
                                            <td width=""></td>
                                            <td width="10px"></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width=""></td>
                                            <td width=""></td>
                                            <td width="10px"></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width=""></td>
                                            <td width=""></td>
                                            <td width="10px"></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width=""></td>
                                            <td width=""></td>
                                            <td width="10px"></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width="85%" colspan="2"><b>Syarat Khusus - Performance Bond</b></td>
                                            <td width="10px"></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td width="10px" valign="top">-</td>
                                            <td width="85%">Surat Penunjukan / Penetapan Pengumuman Lelang / Surat Perintah Kerja (SPK) Kontrak Kerja</td>
                                            <td width="10px" valign="top">:</td>
                                            <td valign="top"><x-btn-lihat-berkas file="{{ $suretyBond->berkas_khusus_1 }}" /></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex mt-3 justify-content-center">
                            <p class="text-{{ $suretyBond->status == 'Selesai' ? 'success' : 'danger' }} m-0 font-weight-bold h5">{{ $suretyBond->status }}</p>
                            <span class="px-4">|</span>
                                @if ($suretyBond->catatan)
                                    <p class="text-danger m-0 font-weight-bold h5">{{ $suretyBond->catatan }}</p>
                                @else
                                    {{ '-' }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @cannot('is-user')
                    <div class="col-12">
                        <div class="card card-success shadow-sm">
                            <div class="card-header">
                                <h3 class="card-title m-auto">Progres</h3>
                                <div class="card-tools">
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="dataTable" class="table table-striped table-bordered compact" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="5px">No</th>
                                            <th>Pengguna</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($suretyBond->progres as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->user ? $item->user->name : '-' }}</td>
                                                <td>{{ $item->status }}{{ $item->catatan ? ' ('.$item->catatan.')' : '' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y | H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                @endcannot
            </div>
            <!-- /.card -->
            <div class="d-none d-print-inline">
                <span class="text-muted">Dicetak pada : {{ date('d-m-Y H:i') }} WIB</span>
            </div>
        </div>
    </div>    
    <div class="modal fade" id="modalCatatan" tabindex="-1" role="dialog" aria-labelledby="modalCatatanLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modalCatatanLabel">Update Progres & Tambah Catatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('surety-bond.updateStatus', $suretyBond->slug) }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        @method('put')
                        <select class="form-control custom-select mb-2" name="status">
                            <option value="Proses">Proses</option>
                            <option value="Selesai">Selesai</option>
                            @cannot('is-user')
                                <option value="Ditolak">Ditolak</option>
                                <option value="Dibatalkan">Dibatalkan</option>
                            @endcannot
                        </select>
                        <input class="form-control" name="catatan" placeholder="Catatan / Nomor Sertifikat Penjaminan" required/>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm w-50 m-auto"><i class="fa fa-save mr-1"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('css')
    
@endpush
@push('script')

@endpush
