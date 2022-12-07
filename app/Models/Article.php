<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    //protected $table='artikel';
    protected $fillable = [
        'author_id',
        'title',
        'desc',
        'image',
        'slug'
    ];
    public function sluggable(){
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
