<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'keterangan' => 'required'
        ]);
        Contact::create($request->all());
        return['massage' => 'terimakasih telah menghubungi kami'];

    }

    // get contact all data
    public function getContactData()
    {
        $contact = Contact::all();

        //if empty data
        if($contact->isEmpty()){
            return ['massage' => 'Data tidak ditemukan'];
        }
        return response()->json([
            'success' => true,
            'massage' => 'Data ditemukan',
            'data' => $contact
        ], 200);


    }

    // get contact data by id
    public  function getContactDataById($id)
    {
        $contact =  Contact::find($id);

        //if empty data
        if($contact->isEmpty()){
            return ['massage' => 'Data tidak ditemukan'];
        }
        return response()->json([
            'success' => true,
            'massage' => 'Data ditemukan',
            'data' => $contact
        ], 200);
    }

    // delete contact data by id
    public  function  deleteContactDataById($id)
    {
        //if empty data
        if(Contact::find($id)->null()){
            return ['massage' => 'Data tidak ditemukan'];
        }
        contact::destroy($id);
        return ['massage' => 'Data berhasil dihapus'];
    }

    //delete all contact data
    public function deleteAllContactData()
    {
        //if empty data
        if(Contact::all()->isEmpty()){
            return ['massage' => 'Data tidak ditemukan'];
        }
        Contact::truncate();
        return ['massage' => 'Data berhasil dihapus'];
    }

}
