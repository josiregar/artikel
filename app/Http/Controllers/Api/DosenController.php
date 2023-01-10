<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dosen;
use Illuminate\Support\Facades\Validator;

class DosenController extends Controller
{
    //create data dosen
    public function createDosen(Request $request)
    {
        //validasi data 
        $this->validate($request, [
            'nama' => 'required',
            'alamat' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'nidn' => 'required'
        ]);
        
        //membuat data dosen
        $dosen = Dosen::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'nidn' => $request->nidn
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Dosen berhasil ditambahkan',
            'data' => $dosen
        ], 201);
    }

    public function getAllDosen() {
        // if not found Dosen
        if (Dosen::all()->count() == 0) {
            return response([
                'message' => 'Dosen not found'
            ], 404);
        }
        $dosen = Dosen::all();
        return response()->json([
            'message' => 'Dosen retrieved successfully',
            'data' => $dosen
        ], 200);
    }

    //get dosen by id
    public function getDosenById($id)
    {
        $dosen=Dosen::find($id);
        if ($dosen == null) {
            return response([
                'message' => 'Dosen not found',
            ], 404);
        }
        return response()->json([
            'message' => 'Dosen retrieved successfully',
            'data' => $dosen
        ], 200);
    }

    //get update data dosen
    public function updateDosen(Request $request, $id)
    {
        $dosen=Dosen::find($id);
        
        //if data dosen not found
        if ($dosen == null) {
            return response()->json([
                'message' => 'data dosen not found',
            ], 200);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'alamat' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'nidn' => 'required'

        ]);

        //check if validator fails
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $dosen->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'nidn' => $request->nidn
        ]);

        return response()->json([
            'message' => 'Dosen update successfully',
            'data' => $dosen
        ], 200);
    }

    //delete data dosen by id
    public function deleteDosen ($id)
    {
        $dosen=Dosen::find($id);
         //if data dosen not found
         if (!$dosen)
            return response()->json([
                'message' => 'dosen not found',
            ],200);
        
        $dosen->delete();

        return response()->json([
            'message' => 'dosen deleted successfully'
        ],200);
    }

    //delete all data dosen
    public function deleteAllDosen()
    {
        $dosen = Dosen::all();

        //if data dosen not found
        if (count($dosen) == 0) {
            return response()->json([
                'message' => 'dosen not found',
            ], 200);
        }

        Dosen::truncate();

        return response()->json([
            'message' => 'deleted successfully',
            'data' => $dosen
        ], 200);
    }

}
