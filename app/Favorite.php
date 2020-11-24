<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = [
        'user_id', 'message_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function message(){
        return $this->belongsTo('App\Messages');
    }
}
