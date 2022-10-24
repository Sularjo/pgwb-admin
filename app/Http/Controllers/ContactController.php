<?php

namespace App\Http\Controllers;

use App\Models\jenis_kontak;
use App\Models\kontak;
use App\Models\siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = siswa::paginate(5);
        $data_jkontak = jenis_kontak::paginate(5);

        return view('master_kontak', compact('data', 'data_jkontak'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $siswa = siswa::find($id);
        $j_kontak = jenis_kontak::all();
        return view('tambah_kontak', compact('siswa', 'j_kontak'));
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $masage = [
            'required' => ':attribute harus diisi',
            'min' => ':attribute minimal :min karakter',
            'max' => ':attribute maximal :max karakter',
            'numeric' => ':attribute harus diisi angka',
            'mimes' => ':attribute harus bertipe foto'
        ];

        $this->validate($request, [
            // 'deskripsi' => 'required|min:10'
        ], $masage);

        kontak::create([
            'siswa_id' => $request->id_siswa,
            'jenis_kontak_id' => $request->jenis_kontak,
            'deskripsi' => $request->deskripsi
        ]);

        Session::flash('success', "kontak berhasil ditambahkan!!");
        return redirect('/master_k');
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
        $kontak = siswa::find($id)->kontak()->get();
        // $kontak = siswa::find($id)->kontak()->get()::paginate(1);
        // $data = kontak::paginate(1);
        // return $kontak;
        return view('show_kontak', compact('kontak'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $contact = siswa::find($id)->kontak()->get();
        // $contact = siswa::find($id)->jenis_kontak()->get();
        $kontak = kontak::find($id);
        $j_kontak = jenis_kontak::all();
        // $kontak = kontak::get();
        // return($contact);
        return view('edit_kontak', compact('kontak', 'j_kontak'));
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
        $masage = [
            'required' => ':attribute harus diisi',
            'min' => ':attribute minimal :min karakter',
            'max' => ':attribute maximal :max karakter',
            'numeric' => ':attribute harus diisi angka',
            'mimes' => ':attribute harus bertipe foto'
        ];

        $this->validate($request, [
            // 'nama_p' => 'required|min:7|max:30',
            // 'deskripsi' => 'required|min:10'
        ], $masage);

        $kontak = kontak::find($id);
        $kontak->jenis_kontak_id = $request->jenis_kontak;
        $kontak->deskripsi = $request->deskripsi;

        $kontak->save();
        Session::flash('success', "kontak berhasil diupdate!!");
        return redirect('master_k');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hapus($id)
    {
        $siswa = kontak::find($id)->delete();
        Session::flash('success', "kontak berhasil dihapus!!");
        return redirect('/master_p');
    }

}
