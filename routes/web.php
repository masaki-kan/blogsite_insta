<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//ホーム
Route::get('/', 'PostController@index')->name('index');

//投稿画面
Route::get('new', 'PostController@NewPage')->name('newpage');

//投稿処理
Route::post('newsotre', 'PostController@newpost')->name('new');

//投稿削除処理
Route::any('delete/{post_id}','PostController@destroy')->name('delete');

//投稿内容画面
Route::get('show/{post_id}','CommentController@show')->name('show');

//コメント処理
Route::post('show','CommentController@newcomment')->name('shownew');

//ユーザー確認画面
Route::get('user/{user_id}','ProfileController@index')->name('user');

//ユーザー情報編集画面
Route::get('user/edit/{user_id}','ProfileController@edit')->name('useredit');

//ユーザー情報編集処理
Route::post('user/updata','ProfileController@store')->name('userstore');

//ユーザー登録画面
Route::get('regist', 'PostController@regist')->name('regist');

//いいね処理
Route::get('post/{post_id}/like' , 'LikeController@store');

//いいね削除処理
Route::get('like/{post_id}' , 'LikeController@destroy');

//検索画面
Route::get('search' , 'PostController@search')->name('search');

//検索処理
Route::get('result' , 'PostController@result')->name('result');






