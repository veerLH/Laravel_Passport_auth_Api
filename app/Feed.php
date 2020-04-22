<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    //
    protected $fillable=[
        'user_id',
        'description',
        'image'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function comments()
    {
        return $this->hasMany('App\Comment', 'feed_id');
    }

    public function like()
    {
        return $this->hasMany('App\Like', 'feed_id');
    }

 
}
