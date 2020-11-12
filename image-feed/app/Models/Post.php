<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $fillable = [
        'title', 'image_id', 'user_id', 'state_id'
    ];

    public function state()
    {
        $this->belongsTo('App\Models\State');
    }
    public function image()
    {
        $this->morphOne('App\Models\Image', 'imageable');
    }
}
