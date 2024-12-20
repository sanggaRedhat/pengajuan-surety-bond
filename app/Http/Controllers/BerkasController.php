<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BerkasController extends Controller
{

    public function view(Request $request)
    {
        $berkas = storage_path('app/berkas/'.$request->path.$request->filename);
        if(file_exists($berkas)) return response()->file($berkas);
        return abort(404);
    }
}
