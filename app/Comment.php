<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $fillable=[
        'user_id',
        'feed_id',
        'comments',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function feed()
    {
        return $this->belongsTo('App\Feed', 'feed_id');
    }
}
