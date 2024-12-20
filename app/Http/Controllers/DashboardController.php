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
            $data['pengajuan'] = SuretyBond::where('status', 'Baru');
            $data['users'] = User::whereHas('roles', fn($role) => $role->where('name', 'user'))->get();
            return view('dashboard.admin', $data);
        }
    }

    public function dashboardAdminNew()
    {
        if(request()->ajax()) {
            return DataTables::of(SuretyBond::latest()->where('status', 'Baru')->get())
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
                $aksi = '';
                $aksi .= '<a href="'.route('surety-bond.show', [$query->slug, 'act' => 'proses-pengajuan']).'" class="btn btn-xs btn-info mr-1">Proses</a>';
                $aksi .= '<a href="javascript:;" onclick="modalRequestTo(\''.$query->id.'\')" class="btn btn-xs btn-info" data-toggle="modal" data-target="#modalRequestTo">Request To</a>';
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
                return $status;
            })
            ->addColumn('kepada', function($query) {
                return $query->request->requestedTo->name;
            })
            ->rawColumns(['tgl_pengajuan','keterangan','status','kepada'])
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
                return $status;
            })
            ->addColumn('oleh', function($query) {
                return $query->request->requestedTo->name;
            })
            ->rawColumns(['tgl_pengajuan','keterangan','status','oleh'])
            ->make(true);
        }
    }

    public function dashboardUser()
    {
        $data['pengajuan'] = SuretyBond::latest()->whereHas('request', function($query) {
            return $query->where('requested_to', auth()->id());
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
                    $aksi .= '<a href="'.route('surety-bond.show', [$query->slug, 'req-id' => $query->request->id, 'act' => 'proses-pengajuan']).'" class="btn btn-xs btn-info mr-1">Proses Pengajuan</a>';
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
