<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Post;
use Illuminate\Support\Facades\Storage;
use Validator;

use Auth;

class CommentController extends Controller
{
    //
    //コメント画面表示
    //Post投稿idから取得
    public function show($post_id){
        $shows = Post::find($post_id);
        return view('post.show',['shows' => $shows]);
    }
    
    //コメント追加処理
    public function newcomment(Request $request){
    //バリデーション設定
        $valirules = Validator::make($request->all(),
        [ 'comment' => 'required|max:140',
          'comment_image' => [
                // 必須
                //'required',
                // アップロードされたファイルであること
                'file',
                //サイズ
                'max:10240',
                // 画像ファイルであること
                'image',
                // MIMEタイプを指定
                'mimes:jpeg,JPEG,png,PNG,jpg,JPG,heic,HEIC,gif,GIF'
                ],
        ],
        [ 'comment.required' => '140文字以内で投稿内容を入力してください',
        ]
    );
    //エラー設定
    if( $valirules->fails() ){
        return redirect()->back()->withErrors($valirules)->withInput();
    }
    //コメント処理の中身
        $newcomments = new Comment;
        
        $form = $request->all();
        $form['user_id'] = Auth::user()->id;
        unset($form['_token']);

        if( isset( $form['comment_image'] ) ){
    //storage保存
           $image = $request->comment_image;
           $image_ext = $image->getClientOriginalExtension();
           $text = str_random(20);
           $imagedata = $text . '.' . $image_ext;
           $form['comment_image'] = $imagedata;
           $request->file('comment_image')->storeAs('public/comment_image' , $imagedata);
            
        }
    //DB保存
    //POSTされた画像ファイルデータ取得しbase64でエンコードする
       if( isset( $post_form['comment_image'] ) ){
           $DB_image = $request->file_name;
           $newcomments->c_image = base64_encode(file_get_contents( $DB_image ));
       }
        $newcomments->fill($form)->save();
        return redirect()->back();
    }
}
