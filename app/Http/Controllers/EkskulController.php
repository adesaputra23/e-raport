<?php

namespace App\Http\Controllers;

use App\Ekskul;
use Illuminate\Http\Request;

class EkskulController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Ekskul';
        $list_data = Ekskul::get();
        return view('ekskul.index',
            compact(
                'title',
                'list_data',
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $get_ekskul = Ekskul::find($id);
        return view('ekskul.created_form',
            compact(
                'get_ekskul',
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->action === 'tambah') {
            $simpan_data = new Ekskul();
            $simpan_data->kode_ekskul = $request->kode_ekskul;
            $simpan_data->created_at = date('Y-m-d H:i:s');
            $message = 'Berhasil tambah data';
        }elseif($request->action === 'ubah'){
            $simpan_data = Ekskul::where('kode_ekskul', $request->id)->first();
            $simpan_data->updated_at = date('Y-m-d H:i:s');
            $message = 'Berhasil ubah data';
        }

        try {
            $simpan_data->nama_ekskul = $request->nama_ekskul;
            $simpan_data->desc_ekskul = $request->desc_ekskul;
            $simpan_data->save();
            return redirect()->route('ekskul.lihat.data.admin')->with('success', $message);
        } catch (\Throwable $th) {
            return redirect()->route('ekskul.lihat.data.admin')->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $deleted = Ekskul::find($id);
            $deleted->delete();
            return redirect()->route('ekskul.lihat.data.admin')->with('success', 'Berhasil hapus data');
        } catch (\Throwable $th) {
            return redirect()->route('ekskul.lihat.data.admin')->with('error', $th->getMessage());
        }
    }
}
