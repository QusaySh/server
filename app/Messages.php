<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $fillable = [
        'message', 'user_id'
    ];

    public function users(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
