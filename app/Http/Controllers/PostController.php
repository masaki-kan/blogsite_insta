<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use App\Like;
use Auth;
use Validator;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    //
    //ログインしていなかったらログイン画面に
    public function __construct(){
        $this->middleware('auth');
    }
    
    //ホーム画面
    //投稿が１０個で次のページへ
    public function index(){
        $alls = Post::orderBy('created_at','desc')->paginate(10);
        
        return view('post.main' , ['alls' => $alls ]
        );
    }
    
    //新規投稿画面
    public function NewPage(){
        return view('post.new');
        
    }
    
    //新規投稿処理
    public function newpost(Request $request){
        //バリデーション設定
        $valirules = Validator::make($request->all(),
        [ 
          'body' => 'required|max:140',
          'file_name' => [
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
        [ 
          'body.required' => '内容を１４０文字以内でを入力してください',
          'file_name.file' => 'アップロード画像のみです',
        ]
    );
    //エラー表示
    if( $valirules->fails() ){
        return redirect()->back()->withErrors($valirules)->withInput();
    }
    
    //処理

        $news = new Post;
    //file_nameの保存
    //upファイルをstorage保存
        $post_form = $request->all();
        $post_form_userid = Auth::user()->id;
        $post_form['user_id'] = $post_form_userid;
        unset($post_form['_token']);
        if(isset($post_form['file_name'])){
            $image = $request->file_name;
            $image_extension = $image->getClientOriginalExtension();
            $image_title = str_random(20);
            $image_file = $image_title . '.' . $image_extension;
            $post_form['file_name'] = $image_file;
            $image_to_DB = $request->file('file_name')->storeAs('public/post_image', $image_file);
       }
    //DB保存
       if( isset( $post_form['file_name'] ) ){
           $DB_image = $request->file_name;
           $news->image = file_get_contents( $DB_image );
       }
        $news->fill($post_form)->save();
        return redirect()->route('index');
    }
    
    public function edit($post_id){
        //投稿編集画面
        //今回は非処理
        $edits = Post::find($post_id);
        
        return view('post.edit',[ 'edits' => $edits ]);
        
    }
    public function update(Request $request){
        //投稿更新処理
        //今回は非処置
        
        //バリデーション設定
        $valirules = Validator::make($request->all(),
        [ 
          'title' => 'required|max:50',
          'body' => 'required|max:140',
        ],
        [ 'title.required' => '投稿名を５０文字以内で入力してください',
          'body.required' => '内容を１４０文字以内でを入力してください',
        ]
    );
    //エラー表示
    if( $valirules->fails() ){
        return redirect()->back()->withErrors($valirules)->withInput();
    }
    
    //更新処理
    $alls = Post::find($request->id);
    $upimg = $request->all();
    unset( $upimg['_token'] );
    
    if( isset( $upimg[ 'file_name' ]) ){
        $dataname = $request->file_name;
        $path = storage_path() . '/app/public/post_image' . $dataname;
        Storage::disk('public')->delete($path);
        
        if( $upimg[ 'file_name' ] == 'no-file_name' ){
            $upimg[ 'file_name' ]  = null; 
            
        }else{
            
            $image = $request->file('file_name');
            $ext = $image->getClientOriginalExtension();
            $text = str_random(20);
            $iamge_data = $text . '.' . $ext;
            $upimg['file_name'] = $iamge_data;
            $request->file('file_name')->storeAs('public/post_image', $iamge_data);
        }
    }
    $alls->fill($upimg)->save();
    
    return redirect()->back();
    }
    
    //削除処理
    public function destroy($post_id){
        
        $data = Post::find($post_id);
        $dataname = $data->file_name;
        Storage::disk('public')->delete('post_image' . $dataname);
        Post::where('id' , $post_id)->delete();
        return redirect()->back();
    }
    
    //検索画面
    //投稿が１０個で次のページへ
    public function search(){
        
        $alls = Post::orderBy('created_at','desc')->paginate(10);
        
        return view('post.search' , ['alls' => $alls ] );
    }

    //検索処理
    //投稿が１０個で次のページへ
    public function result(Request $request){
        $keyword = $request->input('keyword');
        
        $data = Post::query();
        
        if( !empty($keyword) ){
        Post::where('body', 'Like' , '%'.$keyword.'%');
        }
        $alls = $data->where('body', 'Like' , '%'.$keyword.'%')->orderBy('created_at' , 'desc')->paginate(10);
        return view('post.search' , ['alls' => $alls ] );
    }

}
