<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Articlecontroller extends Controller
{
    /**Created Article */
    public function createArticle(Request $request){
        $this->validate($request,[
            'title' => 'required',
            'desc' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'author_id' => 'required'
        ]);
        
        //only admin create new article
        if(Auth::user()->role !='admin') {
            return response([
                'message' => 'anda bukan admin, tidak bisa membuat artikel'
            ], 403);
        }

        $article=Article::create([
            'author_id' => $request->author_id,
            'title' => $request->title,
            'desc' => $request->desc,
            // image should be storage/app/public
            'image' => $request->file('image')->store('public', 'public'),
            'slug' => \Str::slug($request->title)

        ]);

        return response([
            'message' => 'Artikel berhasil dibuat',
            'data' => $article
        ], 201);

        
        

    } 
}
