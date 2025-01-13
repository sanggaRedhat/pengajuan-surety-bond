<?php

namespace App\Http\Controllers;

use App\Helpers\IDDateFormat;
use App\Models\SuretyBond;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{

    public function index()
    {
        if (Gate::allows('is-user')) {
            return $this->dashboardUser();    
        } else {
            $data['pengajuan'] = SuretyBond::where('status', 'Baru')->orWhere('status', 'Diterima');
            $data['users'] = User::whereHas('roles', fn($role) => $role->where('name', 'user'))->get();
            return view('dashboard.admin', $data);
        }
    }

    public function dashboardAdminNew()
    {
        if(request()->ajax()) {
            return DataTables::of(SuretyBond::latest()->where('status', 'Baru')->orWhere('status', 'Diterima')->get())
            ->addIndexColumn()
            ->addColumn('no_tiket', function($query){
                return $query->no_tiket;
            })
            ->addColumn('nama_pemohon', function($query){
                return $query->nama_pemohon;
            })
            ->addColumn('nilai_kontrak', function($query){
                $nilai_kontrak = \App\Helpers\IDRCurrency::convert($query->nilai_kontrak, true);
                return $nilai_kontrak;
            })
            ->addColumn('tgl_pengajuan', function($query){
                return IDDateFormat::convert($query->created_at, true);
            })
            ->addColumn('status', function($query){
                $status = $query->getStatusHtml();
                return $status;
            })
            ->addColumn('aksi', function($query) {
                $nowa = substr($query->nomor_pemohon, 0, 1) == 0 ? '+62' : '';
                $nowa = $nowa.substr($query->nomor_pemohon, 1, 25);
                $aksi = '';
                if ($query->status == 'Baru') {
                    $aksi .= '<a href="https://wa.me/'.$nowa.'?text=Nomor Tiket : '.$query->no_tiket.'%0A%0ANama yang mengajukan : '.$query->nama_pemohon.'%0APerusahaan : '.$query->nama_perusahaan.'%0AJenis Penjaminan : '.$query->jenis_penjaminan.'%0ANilai Kontrak : '.\App\Helpers\IDRCurrency::convert($query->nilai_kontrak, true).'%0APekerjaan : '.$query->pekerjaan.'%0ATanggal Pengajuan : '.IDDateFormat::convert($query->created_at, true).'%0A%0AKonfirmasi balas Ya atau klik link di bawah ini jika data di atas benar diajukan oleh saudara dan saudara bisa melihat progres melalui link.%0A'.url()->route('public-home.status', $query->slug).'" target="_blank" class="btn btn-xs btn-dark mr-1 mb-1">Konfirmasi</a>';
                    $aksi .= '<a href="javascript:;" onclick="confirmRejected(\''.$query->slug.'\')" class="btn btn-xs btn-danger mr-1 mb-1">Tolak</a>';
                    $aksi .= '<a href="javascript:;" onclick="confirmAccepted(\''.$query->slug.'\')" class="btn btn-xs btn-success mr-1 mb-1">Terima</a>';
                } else {
                    $aksi .= '<a href="'.route('surety-bond.show', [$query->slug, 'act' => 'proses-pengajuan']).'" class="btn btn-xs btn-info mr-1">Proses</a>';
                    $aksi .= '<a href="javascript:;" onclick="modalRequestTo(\''.$query->id.'\')" class="btn btn-xs btn-info" data-toggle="modal" data-target="#modalRequestTo">Request To</a>';
                }
                return $aksi;
            })
            ->rawColumns(['tgl_pengajuan','keterangan','status','aksi'])
            ->make(true);
        }
    }

    public function dashboardAdminRequest()
    {
        if(request()->ajax()) {
            return DataTables::of(SuretyBond::latest()->where('status', 'Pending Request')->has('request')->get())
            ->addIndexColumn()
            ->addColumn('no_tiket', function($query){
                return $query->no_tiket;
            })
            ->addColumn('nama_pemohon', function($query){
                return $query->nama_pemohon;
            })
            ->addColumn('nilai_kontrak', function($query){
                $nilai_kontrak = \App\Helpers\IDRCurrency::convert($query->nilai_kontrak, true);
                return $nilai_kontrak;
            })
            ->addColumn('tgl_pengajuan', function($query){
                return IDDateFormat::convert($query->created_at, true);
            })
            ->addColumn('status', function($query){
                $status = $query->getStatusHtml();
                return $status.'<span class="d-block">('.$query->request->last()->requestedTo->name.')</span>';
            })
            ->addColumn('aksi', function($query) {
                $aksi = '';
                $aksi .= '<a href="javascript:;" onclick="confirmRedirected(\''.$query->slug.'\', \''.$query->request->last()->id.'\',)" class="btn btn-xs btn-danger mr-1">Alihkan</a>';
                $aksi .= '<a href="'.route('surety-bond.show', [$query->slug, 'req-id' => $query->request->last()->id, 'act' => 'proses-pengajuan', 'rd' => Gate::denies('is-user') ? 'redirected-true' : 'null']).'" class="btn btn-xs btn-info mr-1">Proses</a>';
                return $aksi;
            })
            ->rawColumns(['tgl_pengajuan','keterangan','status','kepada','aksi'])
            ->make(true);
        }
    }

    public function dashboardAdminProcess()
    {
        if(request()->ajax()) {
            return DataTables::of(SuretyBond::latest()->where('status', 'Proses')->get())
            ->addIndexColumn()
            ->addColumn('no_tiket', function($query){
                return $query->no_tiket;
            })
            ->addColumn('nama_pemohon', function($query){
                return $query->nama_pemohon;
            })
            ->addColumn('nilai_kontrak', function($query){
                $nilai_kontrak = \App\Helpers\IDRCurrency::convert($query->nilai_kontrak, true);
                return $nilai_kontrak;
            })
            ->addColumn('tgl_pengajuan', function($query){
                return IDDateFormat::convert($query->created_at, true);
            })
            ->addColumn('status', function($query){
                $status = $query->getStatusHtml();
                $aksi = '<div>';
                $aksi .= '<a href="'.route('surety-bond.show', [$query->slug, 'act' => 'lanjut-proses-pengajuan']).'" class="btn btn-xs btn-info mr-1">Lanjut Proses</a>';
                $aksi .= '<a href="'.route('surety-bond.show', $query->slug).'" class="btn btn-xs btn-dark mr-1">Detail</a>';
                $aksi .= '</div>';
                return $status.$aksi;
            })
            ->addColumn('oleh', function($query) {
                return $query->progres->last()->user->name;
            })
            ->rawColumns(['tgl_pengajuan','keterangan','status','oleh'])
            ->make(true);
        }
    }

    public function dashboardUser()
    {
        $data['pengajuan'] = SuretyBond::latest()->whereHas('request', function($query) {
            return $query->where('requested_to', auth()->id())->where('is_redirected', 0);
        })->whereIn('status', ['Pending Request', 'Proses'])->get();

        if(request()->ajax()) {
            return DataTables::of($data['pengajuan'])
            ->addIndexColumn()
            ->addColumn('no_tiket', function($query){
                return $query->no_tiket;
            })
            ->addColumn('nama_pemohon', function($query){
                return $query->nama_pemohon;
            })
            ->addColumn('nilai_kontrak', function($query){
                $nilai_kontrak = \App\Helpers\IDRCurrency::convert($query->nilai_kontrak, true);
                return $nilai_kontrak;
            })
            ->addColumn('tgl_pengajuan', function($query){
                return IDDateFormat::convert($query->created_at, true);
            })
            ->addColumn('status', function($query){
                $status = $query->getStatusHtml();
                return $status;
            })
            ->addColumn('aksi', function($query){
                $aksi = '';
                if ($query->status == 'Pending Request') {
                    $aksi .= '<a href="'.route('surety-bond.show', [$query->slug, 'req-id' => $query->request->last()->id, 'act' => 'proses-pengajuan']).'" class="btn btn-xs btn-info mr-1">Proses Pengajuan</a>';
                } else {
                    $aksi .= '<a href="'.route('surety-bond.show', [$query->slug, 'act' => 'lanjut-proses-pengajuan']).'" class="btn btn-xs btn-info mr-1">Lanjut Proses</a>';
                }
                return $aksi;
            })
            ->rawColumns(['tgl_pengajuan','keterangan','status','aksi'])
            ->make(true);
        }

        return view('dashboard.user', $data); 
    }
}
