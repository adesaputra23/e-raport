<?php

namespace App\Http\Controllers;

use App\Kurikulum;
use Illuminate\Http\Request;

class KurikulumController extends Controller
{
    public function LihatData()
    {
        $list_kurikulum = Kurikulum::get();
        return view('kurikulum/lihat_data', 
            compact(
                'list_kurikulum'
            )
        );
    }

    public function FormTambahData($kode_kurikulum)
    {
        $get_kurikulum = Kurikulum::where('kode_kurikulum', $kode_kurikulum)->first();
        $data_kurikulum = $get_kurikulum !== null ? $get_kurikulum : null;
        return view('kurikulum.form_tambah_data',
            compact(
                'data_kurikulum'
            )
        );
    }

    public function SimpanData(Request $request)
    {

        if ($request->status_kurikulum == 1) {
           $data = Kurikulum::where('status_kurikulum', 1)->first();
           $data->status_kurikulum = 2;
           $data->save();
        }

        if ($request->action === 'tambah') {
            $simpan_data = new Kurikulum();
            $simpan_data->kode_kurikulum = $request->kode_kurikulum;
            $simpan_data->created_at = date('Y-m-d H:i:s');
            $message = 'Berhasil tambah data';
        }elseif($request->action === 'ubah'){
            $simpan_data = Kurikulum::where('kode_kurikulum', $request->id)->first();
            $simpan_data->updated_at = date('Y-m-d H:i:s');
            $message = 'Berhasil ubah data';
        }

        try {
            $simpan_data->nama_kurikulum = $request->nama_kurikulum;
            $simpan_data->desc_kurikulum = $request->desc_kurikulum;
            $simpan_data->status_kurikulum = $request->status_kurikulum;
            $simpan_data->save();
            return redirect()->route('kurikulum.lihat.data.admin')->with('success', $message);
        } catch (\Throwable $th) {
            return redirect()->route('kurikulum.lihat.data.admin')->with('error', $th->getMessage());
        }
    }

    public function hapusData($kode_kurikulum)
    {
        try {
            $deleted = Kurikulum::find($kode_kurikulum);
            $deleted->delete();
            return redirect()->route('kurikulum.lihat.data.admin')->with('success', 'Berhasil hapus data');
        } catch (\Throwable $th) {
            return redirect()->route('kurikulum.lihat.data.admin')->with('error', $th->getMessage());
        }
    }
}
