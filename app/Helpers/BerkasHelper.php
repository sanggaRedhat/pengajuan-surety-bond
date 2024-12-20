<?php

namespace App\Helpers;

class BerkasHelper {


    public static function getPath(
        $file
    ) : string {
        $exp = explode('/', $file);
        return $exp[0].'/'.$exp[1].'/';
    }

    public static function getFilename(
        $file
    ) : string {
        $exp = explode('/', $file);
        return $exp[2];
    }

    public static function filenameHandler($request, $file, $newFilename, $slug)
    {
        $dateDir = date("Y/m/");

        if ($request->hasFile($file)) {
            $file = $request->file($file);

            $filename = $dateDir.$newFilename.'-'.str($request->nama_pemohon.'-'.$request->nama_perusahaan.'-')->slug().'-'.substr($slug, 0, 8).'.'.$file->extension();

            return $filename;
        }

        return null;
    }

    public static function uploadHandler($request, $file, $filename)
    {
        if ($request->hasFile($file)) {
            $file = $request->file($file);
    
            \Illuminate\Support\Facades\Storage::putFileAs(
                'berkas', $file, $filename
            );
        }
    }

}
