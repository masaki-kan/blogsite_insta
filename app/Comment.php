<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $fillable = [
        'comment','post_id','comment_image','user_id'
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
