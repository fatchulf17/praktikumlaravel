<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{

    public function index(Request $request)
    {
        $cari = $request->cari;

        $data_mahasiswa = DB::table('mahasiswa')->where('nama','like',"%".$cari."%")->paginate(5);

        return view('mahasiswa.index',['data_mahasiswa'=> $data_mahasiswa]);
    }

    public function create(Request $request)
    {
        mahasiswa::create($request->all());
        return redirect('/mahasiswa') ->with('Sukses', 'Data berhasil diinput!');
    }

    public function edit($id)
    {
        $data_mahasiswa = \App\Models\Mahasiswa::find($id);
        return view('mahasiswa.edit',['mahasiswa' => $data_mahasiswa]);
    }

    public function update(Request $request, $id)
    {
        $data_mahasiswa = \App\Models\Mahasiswa::find($id);
        $data_mahasiswa->update($request->all());
        return redirect('/mahasiswa')->with('Sukses', 'Data berhasil diupdate');
    }

    public function delete($id)
    {
        $data_mahasiswa = \App\Models\Mahasiswa::find($id);
        $data_mahasiswa->delete();
        return redirect('/mahasiswa')->with('Sukses','Data berhasil dihapus');
    }

    public function exportPdf()
    {
        $data_mahasiswa = \App\Models\Mahasiswa::all();
        $pdf = PDF::loadView('export.mahasiswapdf', ['mahasiswa' => $data_mahasiswa]);
        return $pdf->download('mahasiswa.pdf');
    }
}
