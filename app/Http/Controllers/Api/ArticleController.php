<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**Created Article */
    public function createArticle(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'desc' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'author_id' => 'required'
        ]);

        // only admin can create new article
        if (Auth::user()->role != 'admin') {
            return response([
                'message' => 'anda bukan admin, tidak bisa membuat article'
            ], 403);
        }

        $article=Article::create([
            'author_id' => $request->author_id,
            'title' => $request->title,
            'desc' => $request->desc,
            // image should be stored in storage/app/public
            'image' => $request->file('image')->store('article', 'public'),
            'slug' => \Str::slug($request->title)
        ]);

        return response()->json([
            'message' => 'Added article successfully',
            'data' => $article
        ], 201);

    }

    public function getAllArticle(){
        // if not found Article
        if (Article::all()->count() == 0) {
            return response([
                'message' => 'Article not found'
            ], 404);
        }
        $article = Article::all();
        return response()->json([
            'message' => 'Article retrieved successfully',
            'data' => $article
        ], 200);
    }

    /**Get Article By Id */
    public function getArticleById($id){

        $article = Article::find($id);

        if ($article == null) {
            return response([
                'message' => 'article not found'
            ], 404);
        }
        return response()->json([
            'message' => 'article retrieved successfully',
            'data' => $article
        ], 200);
    }

    /**Update Article */
    public function updateArticle(Request $request, $id){

         // only admin can create new article
         if (Auth::user()->role != 'admin') {
            return response([
                'message' => 'anda bukan admin, tidak bisa update article'
            ], 403);
        }
        $article = Article::find($id);

        // if empty data
        if($article == null){
            return ['message' => 'Data Not Found'];
        }

        $this->validate($request, [
            'title' => 'required',
            'desc' => 'required',
            'image' => 'required',
            'author_id' => 'required'
        ]);

        $article->update($request->all());
        return ['message' => 'Data Update Successfully'];
    }

    
    /**Delete Article By Id**/
    public function deleteArticle($id)
    {
        if (Auth::user()->role != 'admin') {
            return response([
                'message' => 'anda bukan admin, tidak bisa delete'
            ], 403);
        }

        $article = Article::find($id);

        // if empty data
        if($article == null){
            return ['message' => 'Data Not Founds'];
        }

        $article->delete();
        return ['message' => 'Delet data Article successfully'];
    }

    /**Delete All Article */
    public function deleteAllArticle(){

        $article = Article::all();
        // only admin can create new article
        if (Auth::user()->role != 'admin') {
            return response([
                'message' => 'anda bukan admin, tidak bisa delete all article'
            ], 403);
        }
        // if empty data
        if($article->isEmpty()){
            return ['message' => 'Data Not Found'];
        }

        $article->each->delete();
        return ['message' => 'Delete all data Article Successfully'];
    }
}