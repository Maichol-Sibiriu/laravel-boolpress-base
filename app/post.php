<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    protected $fillable = [
        'title',
        'body',
        'slug',
        'path_img',
    ];

    public function tags(){
        return $this->belongsToMany('App\Tag');
    }
}
