<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    //create data mahasiswa
    public function create(Request $request)
    {
        //validasi data
        $this->validate($request, [
            'nama' => 'required',
            'alamat' => 'required',
            'tempat_lahir' => 'required',
            'tanggal lahir' => 'required',
            'npm' => 'required'
        ]);

        //membuat data mahasiswa
        $mahasiswa = Mahasiswa::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'npm' => $request->npm
        ]);
        if($mahasiswa){
            return response()->json([
                'success' => true,
                'message' => 'Mahasiswa berhasil ditambahkan',
                'data' => $mahasiswa
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa gagal ditambahkan',
                'data' => ''
            ], 400);
        }
    }
}
