<?php

namespace App\Http\Controllers;

use App\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $list_data = Pengumuman::get();
        return view('pengumuman/index', compact('list_data'));
    }

    public function form_data($id)
    {
        $pengumuman = Pengumuman::find($id);
        $title = 'Tambah';
        if (!empty($pengumuman)) {
            $title = 'Ubah';
        }
        return view('pengumuman/form_data', compact('pengumuman', 'title'));
    }

    public function save(Request $request)
    {
        try {
            if ($request->action === 'tambah') {
                $save_data = new Pengumuman();
                $message = 'Berhasil tambah data pengumuman';
            }elseif ($request->action === 'ubah' ) {
                $save_data = Pengumuman::find($request->id);
                $message = 'Berhasil ubah data pengumuman';
            }
            $save_data->judul   = $request->judul;
            $save_data->isi     = $request->area;
            $save_data->tanggal = date($request->tanggal.' H:i:s');
            $save_data->save();
            return redirect()->route('pengumuman.index')->with('success', $message);
        } catch (\Throwable $th) {
            return redirect()->route('pengumuman.index')->with('error', $th->getMessage().' / '.$th->getLine().', Eror');
        }
    }

    public function delete($id)
    {
        try {
            $data = Pengumuman::find($id);
            $data->delete();
            $message = 'Berhasil hapus data pengumuman';
            return redirect()->route('pengumuman.index')->with('success', $message);
        } catch (\Throwable $th) {
            return redirect()->route('pengumuman.index')->with('error', $th->getMessage().' / '.$th->getLine().', Eror');
        }
    }

    public function show($id)
    {
        $pengumuman = Pengumuman::find($id);
        return view('pengumuman/show', compact('pengumuman'));
    }

}
