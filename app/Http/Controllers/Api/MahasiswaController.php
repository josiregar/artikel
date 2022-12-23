<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;   
use Illuminate\Support\Facades\Validator;


class MahasiswaController extends Controller
{
    //create data mahasiswa
    public function createMahasiswa(Request $request)
    {
        //validasi data
        $this->validate($request, [
            'nama' => 'required',
            'alamat' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
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
        return response()->json([
            'success' => true,
            'message' => 'Mahasiswa berhasil ditambahkan',
            'data' => $mahasiswa
        ], 201);
    }

    public function getAllMahasiswa(){
        // if not found Mahasiswa
        if (Mahasiswa::all()->count() == 0) {
            return response([
                'message' => 'Mahasiswa not found'
            ], 404);
        }
        $mahasiswa = Mahasiswa::all();
        return response()->json([
            'message' => 'Mahasiswa retrieved successfully',
            'data' => $mahasiswa
        ], 200);
 
   }

   //get mahasiswa by id
   public function getMahasiswaById($id)
   {
       $mahasiswa=Mahasiswa::find($id);
       if ($mahasiswa == null) {
           return response([
               'message' => 'Mahasiswa not found',
           ], 404);
       }
       return response()->json([
           'message' => 'Mahasiswa retrieved successfully',
           'data' => $mahasiswa
       ], 200);
   }
}
