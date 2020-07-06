<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Validator;

class ProfileController extends Controller
{
    //
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
            'password' => 'required|string|min:6|confirmed',
            ]);

        //バリデーションの結果がエラーの場合
        if ($validator->fails())
        {
          return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        //更新処理
        $user = User::find($request->id);
        $user->name = $request->name;
        if ($request->profile_photo !=null) {
            $request->profile_photo->storeAs('public/profile', $user->id . '.jpg');
            $user->profile_photo = $user->id . '.jpg';
        }
        $user->password = bcrypt($request->user_password);
        
        if ($request->user_profile_photo !=null) {
            $user->image = base64_encode(file_get_contents($request->profile_photo));
        }
        
        $user->save();
        return redirect()->route('useredit', $request->id );
    }
}
