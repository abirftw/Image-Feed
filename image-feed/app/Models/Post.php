<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $fillable = [
        'title', 'image_id', 'user_id', 'state_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function image()
    {
        return $this->belongsTo('App\Models\Image');
    }
}
