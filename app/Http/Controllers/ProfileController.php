<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Validator;

class ProfileController extends Controller
{
    //
    
    //ログインしていなかったらログイン画面に
    public function __construct(){
        $this->middleware('auth');
    }
    //ユーザー情報画面
    public function index($user_id){
        $user = User::where('id' , $user_id)->firstOrFail();
        return view ('profile.index' , [ 'user' => $user ]);
    }
    
    //ユーザー情報編集画面
     public function edit(){
         $user = Auth::user();
         return view('profile.edit' , ['user' => $user]);
     }
     //ユーザー情報更新処理
    public function store(Request $request){
         //バリデーション設定（入力値チェック）
        $validator = Validator::make($request->all() , [
            'name' => 'required|string|max:255',
            'email' => 'email',
            //'password' => 'required|string|min:6|confirmed',
            'profile_photo' => [
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
            ]
            ,
            [
                'name.required' => '名前を入力してください',
                'email.email' => 'パスワードを入力してください',
                //'password.required' => '6文字以上からお願いします',
            ]
                );

        //バリデーションの結果がエラーの場合
        if ($validator->fails())
        {
          return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        //更新処理
        
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->profile_photo !=null) {
            $request->profile_photo->storeAs('public/profile', $user->id . '.jpg');
            $user->profile_photo = $user->id . '.jpg';
        }
      //DB保存
      //POSTされた画像ファイルデータ取得しbase64でエンコードする  
        if ($request->profile_photo !=null) {
            $user->photo = base64_encode( file_get_contents($request->profile_photo) );
        }
        $user->save();
        return redirect()->route('useredit', $request->id );
    }
}
