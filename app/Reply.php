<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = ['reply', 'message_id'];

    public function message(){
        return $this->belongsTo('App\Messages');
    }
}
