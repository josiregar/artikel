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

    public function getArticle(){
        if (Article::all()->count() == 0) {
            return response([
                'message' => 'Artikel tidak ditemukan'
            ], 404);
        }
        $article = Article::all();
        return response()->json([
            'message' => 'Artikel berhasil ditemukan',
            'data' => $article
        ], 200);
        
    }
    /**Get Article By Id */
    public function getArticleById($id){
        $article = Article::find($id);

        if (!$article) {
            return response([
                'message' => 'Artikel tidak ditemukan'
            ], 404);
        }
        return response()->json([
            'message' => 'Artikel berhasil ditemukan',
            'data' => $article
        ], 200);
    }

    //Update Article
    public function updateArticle(Request $request, $id){
        $article = Article::find($id);

        // only admin can create new article
        if (Auth::user()->role != 'admin') {
            return response([
                'message' => 'anda bukan admin, tidak bisa mengupdate artikel'
            ], 403);
    }
    $article = Article::find($id);

    // if empety data 
    if (!$article == null) {
        return ['message' => 'Artikel tidak ditemukan'];
    }

    $this->validate($request, [
        'title' => 'required',
        'desc' => 'required',
        'image' => 'required',
        'author_id' => 'required'
    ]);

    $article->update($request->all());
    return ['message' => 'Artikel berhasil diupdate'];
    

}

//Delete Article By Id
public function deleteArticle($id)
{
    if (Auth::user()->role != 'admin') {
        return response([
            'message' => 'anda bukan admin, tidak bisa menghapus artikel'
        ], 403);
    }

    $article = Article::find($id);

    //if empty data
    if (!$article == null) {
        return ['message' => 'Artikel tidak ditemukan'];
    }

    $article->delete();
    return ['message' => 'Artikel berhasil dihapus'];
}

//Delete All Article
public function deleteAllArticle(){
    $article = Article::all();
    //only admin can delete all article
    if (Auth::user()->role != 'admin') {
        return response([
            'message' => 'anda bukan admin, tidak bisa menghapus semua artikel'
        ], 403);
    }

    //if empty data
    if($article->isEmpty()){
        return ['message' => 'Artikel tidak ditemukan'];
    }
    
    $article->each->delete();
    return ['message' => 'Artikel berhasil dihapus'];

}
    
}
