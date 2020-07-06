<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use App\Post;
use Auth;
use App\User;

class LikeController extends Controller
{
    //
    
    //いいねの押す処理（追加処理と同じ）
    public function store(Request $request){
        $like = new Like;
        $like->post_id = $request->post_id;
        $like->user_id = Auth::user()->id;
        $like->save();
        return redirect('/');
    }
    
    //いいねの取り消す処理（削除と同じ）
    public function destroy($post_id){
        Like::find($post_id)->delete();
        return redirect('/');
    }
    
}
