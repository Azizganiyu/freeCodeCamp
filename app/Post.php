<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    protected $guarded = [];
    /*protected $fillable = [
        'caption', 'image',
    ];*/

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
