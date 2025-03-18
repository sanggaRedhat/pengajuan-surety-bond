<?php

namespace App\Http\Controllers\Public;

use App\Helpers\BerkasHelper;
use App\Models\SuretyBond;
use App\Models\SuretyBondProgres;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublicHomeController extends \App\Http\Controllers\Controller
{

    private $maxFileSize = 100000;
    private $fileFormat = 'zip,rar,pdf,png,jpg,jpeg';

    public function index()
    {
        return view('public.form');
    }

    public function status(Request $request)
    {
        $data['suretyBond'] = SuretyBond::where('slug', $request->slug)->with('progres')->first();

        abort_if($data['suretyBond'] == null, 404);
        
        if ($data['suretyBond']->status == 'Baru') {
            SuretyBond::where('id', $data['suretyBond']->id)->update(['status' => 'Diterima']);
            SuretyBondProgres::create(['surety_bond_id' => $data['suretyBond']->id,'status' => 'Diterima']);
            return redirect()->route('public-home.status', $request->slug)->with([
                'status'  => true,
                'message' => 'Konfirmasi berhasil, terima kasih.'
            ]);
        }
        return view('public.status', $data);
    }

    public function sendRequest(Request $request)
    {
        ini_set('post_max_size', '50M');
        ini_set('upload_max_filesize', '50M');

        $request->validate([
            'nama_pemohon'          => 'required|string',
            'jabatan_pemohon'       => 'required|string',
            'email'                 => 'required|email',
            'nomor_pemohon'         => 'required|numeric',
            'nama_perusahaan'       => 'required|string',
            'nama_direktur_perusahaan' => 'required|string',
            'pekerjaan'             => 'required|string',
            'nilai_kontrak'         => 'required|numeric',
            'nilai_jaminan_persen'  => 'required|numeric',
            'jangka_waktu'          => 'required|numeric',
            'jenis_berkas_jaminan'  => 'required|string',
            'jenis_penjaminan'      => 'required|in:Jaminan Penawaran,Jaminan Pelaksanaan,Jaminan Uang Muka,Jaminan Pemeliharaan',
            'berkas_jaminan'        => 'required|file|max:'.$this->maxFileSize.'|mimes:'.$this->fileFormat,
            'berkas_permohonan'     => 'required|file|max:'.$this->maxFileSize.'|mimes:'.$this->fileFormat,
            'berkas_pengalaman_pekerjaan' => 'required|file|max:'.$this->maxFileSize.'|mimes:'.$this->fileFormat,
            'berkas_umum_1'         => 'required|file|max:'.$hs>maxFileSize.'|mimes:'.$this->fileFormat,
            'berkas_umum_2'         => 'required|file|max:'.$this->maxFileSize.'|mimes:'.$this->fileFormat,
            'berkas_umum_3'         => 'required|file|max:'.$this->maxFileSize.'|mimes:'.$this->fileFormat,
            'berkas_umum_4'         => 'required|file|max:'.$this->maxFileSize.'|mimes:'.$this->fileFormat,
            'berkas_umum_5'         => 'required|file|max:'.$this->maxFileSize.'|mimes:'.$this->fileFormat,
            'berkas_umum_6'         => 'required|file|max:'.$this->maxFileSize.'|mimes:'.$this->fileFormat,
            'berkas_perorangan_1'   => 'required|file|max:'.$this->maxFileSize.'|mimes:'.$this->fileFormat,
            'berkas_perorangan_2'   => 'required|file|max:'.$this->maxFileSize.'|mimes:'.$this->fileFormat,
            'berkas_perorangan_3'   => 'required|file|max:'.$this->maxFileSize.'|mimes:'.$this->fileFormat,
            'berkas_khusus_1'       => 'required|file|max:'.$this->maxFileSize.'|mimes:'.$this->fileFormat,
        ]);

        try {
            $slug = str()->uuid();

            $berkasHelper = new BerkasHelper();

            $berkas1 = $berkasHelper->filenameHandler($request, 'berkas_jaminan', 'jaminan', $slug);
            $berkas2 = $berkasHelper->filenameHandler($request, 'berkas_permohonan', 'permohonan', $slug);
            $berkas3 = $berkasHelper->filenameHandler($request, 'berkas_pengalaman_pekerjaan', 'pengalaman-pekerjaan', $slug);
            $berkasUmum1 = $berkasHelper->filenameHandler($request, 'berkas_umum_1', 'berkas-umum-1', $slug);
            $berkasUmum2 = $berkasHelper->filenameHandler($request, 'berkas_umum_2', 'berkas-umum-2', $slug);
            $berkasUmum3 = $berkasHelper->filenameHandler($request, 'berkas_umum_3', 'berkas-umum-3', $slug);
            $berkasUmum4 = $berkasHelper->filenameHandler($request, 'berkas_umum_4', 'berkas-umum-4', $slug);
            $berkasUmum5 = $berkasHelper->filenameHandler($request, 'berkas_umum_5', 'berkas-umum-5', $slug);
            $berkasUmum6 = $berkasHelper->filenameHandler($request, 'berkas_umum_6', 'berkas-umum-6', $slug);
            $berkasPerorangan1 = $berkasHelper->filenameHandler($request, 'berkas_perorangan_1', 'berkas-perorangan-1', $slug);
            $berkasPerorangan2 = $berkasHelper->filenameHandler($request, 'berkas_perorangan_2', 'berkas-perorangan-2', $slug);
            $berkasPerorangan3 = $berkasHelper->filenameHandler($request, 'berkas_perorangan_3', 'berkas-perorangan-3', $slug);
            $berkasKhusus1 = $berkasHelper->filenameHandler($request, 'berkas_khusus_1', 'berkas-khusus-1', $slug);

            $subcode = 'TIKET-SRBJK.'.date('y-m.');
            $latestData = SuretyBond::latest()->first();
            if ($latestData) {
                $number = Carbon::parse($latestData->created_at)->format('Y') == Carbon::parse(now())->format('Y') ? $latestData->no_tiket : 0;
            } else $number = 0;
            $no_tiket = \App\Helpers\RegisterNumber::execute($number, $subcode);

            $data = SuretyBond::create([
                'no_tiket'              => $no_tiket,
                'nama_pemohon'          => $request->nama_pemohon,
                'jabatan_pemohon'       => $request->jabatan_pemohon,
                'email_pemohon'         => $request->email,
                'nomor_pemohon'         => $request->nomor_pemohon,
                'nama_perusahaan'       => $request->nama_perusahaan,
                'nama_direktur_perusahaan' => $request->nama_direktur_perusahaan,
                'pekerjaan'             => $request->pekerjaan,
                'nilai_kontrak'         => $request->nilai_kontrak,
                'nilai_jaminan_persen'  => $request->nilai_jaminan_persen,
                'jangka_waktu'          => $request->jangka_waktu,
                'jenis_berkas_jaminan'  => $request->jenis_berkas_jaminan,
                'jenis_penjaminan'      => $request->jenis_penjaminan,
                'slug'                  => $slug,
                'berkas_jaminan'        => $berkas1,
                'berkas_permohonan'     => $berkas2,
                'berkas_pengalaman_pekerjaan' => $berkas3,
                'berkas_umum_1'         => $berkasUmum1,
                'berkas_umum_2'         => $berkasUmum2,
                'berkas_umum_3'         => $berkasUmum3,
                'berkas_umum_4'         => $berkasUmum4,
                'berkas_umum_5'         => $berkasUmum5,
                'berkas_umum_6'         => $berkasUmum6,
                'berkas_perorangan_1'   => $berkasPerorangan1,
                'berkas_perorangan_2'   => $berkasPerorangan2,
                'berkas_perorangan_3'   => $berkasPerorangan3,
                'berkas_khusus_1'       => $berkasKhusus1,
            ]);

            if ($data) {
                SuretyBondProgres::create(['surety_bond_id' => $data->id,'status' => 'Baru']);
                $berkasHelper->uploadHandler($request, 'berkas_jaminan', $berkas1);
                $berkasHelper->uploadHandler($request, 'berkas_permohonan', $berkas2);
                $berkasHelper->uploadHandler($request, 'berkas_pengalaman_pekerjaan', $berkas3);
                $berkasHelper->uploadHandler($request, 'berkas_umum_1', $berkasUmum1);
                $berkasHelper->uploadHandler($request, 'berkas_umum_2', $berkasUmum2);
                $berkasHelper->uploadHandler($request, 'berkas_umum_3', $berkasUmum3);
                $berkasHelper->uploadHandler($request, 'berkas_umum_4', $berkasUmum4);
                $berkasHelper->uploadHandler($request, 'berkas_umum_5', $berkasUmum5);
                $berkasHelper->uploadHandler($request, 'berkas_umum_6', $berkasUmum6);
                $berkasHelper->uploadHandler($request, 'berkas_perorangan_1', $berkasPerorangan1);
                $berkasHelper->uploadHandler($request, 'berkas_perorangan_2', $berkasPerorangan2);
                $berkasHelper->uploadHandler($request, 'berkas_perorangan_3', $berkasPerorangan3);
                $berkasHelper->uploadHandler($request, 'berkas_khusus_1', $berkasKhusus1);
            }

            return redirect()->back()->with([
                'status'  => true,
                'message' => 'Pengajuan berhasil dikirim, terima kasih.',
                'data_pengajuan' => [
                    'no_tiket'              => $data->no_tiket,
                    'nama_pemohon'          => $data->nama_pemohon,
                    'jabatan_pemohon'       => $data->jabatan_pemohon,
                    'email_pemohon'         => $data->email_pemohon,
                    'nomor_pemohon'         => $data->nomor_pemohon,
                    'nama_perusahaan'       => $data->nama_perusahaan,
                    'nama_direktur_perusahaan' => $data->nama_direktur_perusahaan,
                    'pekerjaan'             => $data->pekerjaan,
                    'nilai_kontrak'         => $data->nilai_kontrak,
                    'nilai_jaminan_persen'  => $data->nilai_jaminan_persen,
                    'jangka_waktu'          => $data->jangka_waktu,
                    'jenis_penjaminan'      => $data->jenis_penjaminan,
                    'created_at'            => $data->created_at,
                    'slug'                  => $data->slug,
                ],
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([
                'status'  => false,
                'message' => 'Data gagal dikirim, silahkan coba lagi.',
            ])->withInput();
        }
    }

}
