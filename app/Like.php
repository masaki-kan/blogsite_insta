<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    //
    protected $fillable = [
        
        'post_id','user_id'
        
        ];
    //postに対して　対１
    public function post(){
        return $this->belongsTo('App\Post');
    }
    //userに対して　対１
    public function user(){
        return $this->belongsTo('App\User');
    }
}
