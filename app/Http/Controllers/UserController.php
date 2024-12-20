<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{

    public function index()
    {
        if(request()->ajax()) {
            return DataTables::of(User::get())
            ->addIndexColumn()
            ->addColumn('is_active',function($query){
                if ($query->is_active) {
                    $text = 'Ya';
                    $confirm = 'Nonaktifkan';
                    $class = 'success';
                } else {
                    $text = 'Tidak';
                    $confirm = 'Aktifkan';
                    $class = 'danger';
                }
                return 
                '<button type="button" onclick="aktifasiPengguna(this,'.$query->id.',\''.$confirm.'\')" class="btn btn-xs btn-block btn-'.$class.'">
                    '.$text.'
                </button>';
            })
            ->addColumn('edit',function($query){
                $btnEdit = '<a href="javascript:;" onclick="edit(this,'.$query->id.')" class="btn btn-xs btn-block btn-info">Edit</a>'; 
                return $btnEdit;
            })
            ->addColumn('hapus',function($query){
                return '<a href="javascript:;" onclick="hapus('.$query->id.')" class="btn delete btn-xs btn-block btn-danger">Hapus</a>';
            })
            ->addColumn('edit_akses',function($query){
                return '<a href="javascript:;" data-toggle="modal" data-target="#modalEditAkses" onclick="editAkses(this,'.$query->id.')" class="btn btn-xs btn-block btn-secondary">Role</a>';
            })
            ->rawColumns(['edit','hapus','is_active','edit_akses'])
            ->make(true);
        }

        return view('pengguna.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
        ]);

        try {
            $pengguna = User::create($validated);

            $pengguna->roles()->sync(3);

            return response()->json([
                    'status'  => true,
                    'message' => 'Data pengguna berhasil disimpan.',
                ]);
        } catch (\Throwable $th) {
            return response()->json([
                    'status'  => false,
                    'message' => 'Data pengguna gagal disimpan.',
                ]);
        }
    }

    public function edit(User $pengguna)
    {
        return response()->json(['status'=>true,'data' => $pengguna]);
    }

    public function update(Request $request, User $pengguna)
    {
        $validated = $request->validate([
            'name'=>'required',
            'email'=>'required',
        ]);

        try {
            if ($request->password) $validated['password'] = $request->password;

            $pengguna->update($validated);

            return response()->json([
                    'status'  => true,
                    'message' => 'Data pengguna berhasil diperbaharui.',
                ]);
        } catch (\Throwable $th) {
            return response()->json([
                    'status'  => false,
                    'message' => 'Data pengguna gagal diperbaharui.',
                ]);
        }
    }

    public function active(Request $request, User $pengguna)
    {
        $pengguna->update(['is_active'=>$request->aktif]);
        return response()->json([
            'status'  => true,
            'message' => 'Data pengguna berhasil diperbaharui.',
        ]);
    }

    public function destroy(User $pengguna)
    {
        try {
            $pengguna->delete();
            return response()->json(['status'=>true,'message' => 'Data berhasil dihapus.']);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'message' => 'Data gagal dihapus.']);
        }
    }

    public function editAkses(User $pengguna)
    {
        return response()->json([
            'status' => true,
            'role' => $pengguna->roles()->first()->name
        ]);
    }

    public function updateAkses(Request $request, User $pengguna)
    {
        try {
            $pengguna->roles()->sync($request->roles);

            return response()->json([
                    'status'  => true,
                    'message' => 'Data akses pengguna berhasil diperbaharui.',
                ]);
        } catch (\Throwable $th) {
            return response()->json([
                    'status'  => false,
                    'message' => 'Data akses pengguna gagal diperbaharui.',
                ]);
        }
    }


    public function profil_saya()
    {
        return view('pengguna.profil-saya');
    }

    public function update_password(Request $request)
    {
        try {
            if (Hash::check($request->current_password, Auth::user()->password)) {

                $user = User::find(Auth::user()->id);
                $user->password = $request->new_password;
                $user->save();

                Auth::logout();
                return response()->json([
                    'status'  => true,
                    'message' => 'Password berhasil diperbaharui.',
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Password lama salah.',
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => 'Password gagal diperbaharui.',
            ]);
        }
    }
    
}
