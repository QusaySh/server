<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $fillable = [
        'message', 'user_id', 'show_message'
    ];

    public function users(){
        return $this->belongsTo('App\User', 'user_id');
    }
    public function favorite(){
        return $this->hasOne('App\Favorite', 'message_id');
    }
    public function reply(){
        return $this->hasMany('App\Reply', 'message_id');
    }
}
