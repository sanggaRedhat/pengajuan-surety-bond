<?php

namespace App\Http\Controllers\Manage;

use App\Helpers\IDDateFormat;
use App\Models\SuretyBond;
use App\Models\SuretyBondProgres;
use App\Models\SuretyBondRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class SuretyBondController extends \App\Http\Controllers\Controller
{

    public function index()
    {
        $query = SuretyBond::latest()->when(Gate::check('is-user'), function($query) {
            return $query->whereHas('request', fn($query2) => $query2->where('requested_to', auth()->id()));
        })->get();

        if(request()->ajax()) {
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('nilai_kontrak', function($query) {
                $nilai_kontrak = \App\Helpers\IDRCurrency::convert($query->nilai_kontrak, true);
                return $nilai_kontrak;
            })
            ->addColumn('tgl_pengajuan', function($query) {
                return IDDateFormat::convert($query->created_at, true);
            })
            ->addColumn('status', function($query){
                $status = $query->getStatusHtml();
                return $status;
            })
            ->addColumn('aksi', function($query) {
                $aksi = '';
                if ($query->status == 'Pending Request') {
                    $aksi .= '<a href="'.route('surety-bond.show', [$query->slug, 'req-id' => $query->request->id, 'act' => 'proses-pengajuan']).'" class="btn btn-xs btn-info mr-1">Proses</a>';
                    if (Gate::denies('is-user')) {
                        $aksi .= '<a href="'.route('surety-bond.show', $query->slug).'" class="btn btn-xs btn-dark mr-1">Detail</a>';
                    }
                } elseif ($query->status == 'Proses') {
                    $aksi .= '<a href="'.route('surety-bond.show', [$query->slug, 'act' => 'lanjut-proses-pengajuan']).'" class="btn btn-xs btn-info mr-1">Lanjut Proses</a>';
                    if ($query->request->requested_to == auth()->id()) {} else {
                        $aksi .= '<a href="'.route('surety-bond.show', $query->slug).'" class="btn btn-xs btn-dark mr-1">Detail</a>';
                    }
                } elseif ($query->status == 'Baru') {
                    $aksi .= '<a href="'.route('surety-bond.show', [$query->slug, 'act' => 'proses-pengajuan']).'" class="btn btn-xs btn-info mr-1">Proses</a>';
                } else {
                    $aksi .= '<a href="'.route('surety-bond.show', $query->slug).'" class="btn btn-xs btn-dark mr-1">Detail</a>';
                }
                return $aksi;
            })
            ->rawColumns(['tgl_pengajuan','keterangan','status','aksi'])
            ->make(true);
        }

        return view('manage.surety_bond.index');
    }

    public function show(Request $request, SuretyBond $suretyBond)
    {
        if ($request->has('act')) {
            if ($request->get('act') == 'proses-pengajuan') {
                $suretyBond->update(['status' => 'Proses']);
                
                if ($request->has('req-id')) {
                    $suretyBond->request()->update([
                        'is_accepted' => 1,
                        'requested_to' => auth()->id(),
                        'accepted_at' => now()
                    ]);
                } else {
                    $suretyBond->request()->create([
                        'requested_by' => auth()->id(),
                        'requested_to' => auth()->id(),
                        'requested_at' => now(),
                        'is_accepted' => 1,
                        'accepted_at' => now()
                    ]);
                }
            }

            $suretyBond->progres()->create([
                'user_id' => auth()->id(),
                'status' => 'Proses',
            ]);

            return redirect()->route('surety-bond.show', $suretyBond->slug);
        }

        $suretyBond->load(['progres','request']);

        return view('manage.surety_bond.show', compact('suretyBond'));
    }

    public function requestTo(Request $request)
    {
        try {
            $data = SuretyBondRequest::create([
                'surety_bond_id' => $request->srb_id,
                'requested_by' => auth()->id(),
                'requested_at' => now(),
                'requested_to' => $request->user_id,
            ]);

            if ($data) {
                SuretyBondProgres::create([
                    'surety_bond_id' => $request->srb_id,
                    'user_id' => auth()->id(),
                    'status' => 'Pending Request',
                ]);
                SuretyBond::where('id', $request->srb_id)->update(['status' => 'Pending Request']);
            }
            return response()->json([
                'status'  => true,
                'message' => 'Request berhasil dikirim.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => 'Request gagal dikirim.'
            ]);
        }
    }

    public function updateStatus(Request $request, SuretyBond $suretyBond)
    {
        $suretyBond->update([
            'catatan' => $request->catatan,
            'status' => $request->status,
        ]);
        $suretyBond->progres()->create([
            'user_id' => auth()->id(),
            'status' => $request->status,
        ]);

        return redirect()->route('surety-bond.show', $suretyBond->slug);
    }

}
