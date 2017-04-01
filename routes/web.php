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
Route::get('/','Front\HomeController@index');

Route::get('/home','Front\HomeController@Index')->name('home');
Route::get('admin/login' , 'Admin\AdminController@showLogin');

//Route:: admin
Route::group([	'middleware' => 'AdminMiddleware'], function () {
    Route::get('/admin','Admin\AdminController@index')->name('admin.pages');
    Route::get('/admin/user/restore/{id}', 'Admin\UserController@restore')->name('admin.user.restore');
    Route::get('admin/user/recycle','Admin\UserController@recycle')->name('admin.recycle');
    Route::get('admin/delete/{id}','Admin\UserController@delete')->name('admin.delete');
	Route::resource('admin/page','Admin\PageController');
	Route::resource('admin/user','Admin\UserController');
	Route::get('admin/cate', 'Admin\CateController@index')->name('admin.cate.index');
	Route::get('admin/cate/manage', 'Admin\CateController@manage')->name('admin.cate.manage');
	Route::get('admin/cate/add', 'Admin\CateController@add')->name('admin.cate.add');
	Route::post('admin/cate/add', 'Admin\CateController@save')->name('admin.cate.add');
	Route::get('admin/cate/edit/{id}', 'Admin\CateController@edit')->name('admin.cate.edit');
	Route::post('admin/cate/update/{id}', 'Admin\CateController@update')->name('admin.cate.update');
	Route::get('admin/cate/{id}', 'Admin\PostController@index')->name('admin.post.index');
	Route::get('admin/cate/delete/{id}', 'Admin\CateController@delete')->name('admin.cate.delete');
	Route::get('admin/post/delete/{id}', 'Admin\PostController@delete')->name('admin.post.delete');
	Route::get('admin/post/{id}','Admin\PostController@show')->name('admin.post.show');
	Route::get('admin/post/edit/{id}','Admin\PostController@edit')->name('admin.post.edit');
	Route::post('admin/post/update/{id}','Admin\PostController@update')->name('admin.post.update');
	Route::get('admin/comment/delete/{id}', 'Admin\CommentController@delete')->name('admin.comment.delete');
	Route::get('admin/comment/forceDel/{id}', 'Admin\CommentController@forceDel')->name('admin.comment.forceDel');
	Route::get('admin/comment/restore/{id}', 'Admin\CommentController@restore')->name('admin.comment.restore');
  });  
Route::get('/page/{id}', 'Front\HomeController@show')->name('front.page.show');
Route::get('register',function(){
	return view('user.register');
})->name('register');

Auth::routes();
Route::get('cate', 'Front\CateController@index')->name('cate.index');
Route::get('cate/{id}', 'Front\CateController@show')->name('cate.show');
Route::get('cate/post/{id}', 'Front\CateController@showPost')->name('cate.post.show');
Route::post('login','Front\UserController@login')->name('submitLogin');
Route::post('admin/login','Admin\AdminController@submitLogin')->name('admin.submitLogin');
Route::get('/user/{id}', 'Front\UserController@profile')->where('id', '[0-9]+')->name('user.profile');
Route::get('/user/update/{id}', 'Front\UserController@update')->where('id', '[0-9]+')->name('font.user.update');
Route::post('/user/save/{id}', 'Front\UserController@save')->where('id', '[0-9]+')->name('front.user.save');

//Route posts
Route::group(['middleware'=>'auth'],function(){

	Route::get('post/create/{userId}', 'Post\PostController@create')->name('post.create');
	Route::post('post/store/{userId}', 'Post\PostController@store')->name('post.store');
	Route::get('post/show/{id}','Post\PostController@show')->name('post.show')->middleware('PostMiddleware');
	Route::get('post/edit/{id}','Post\PostController@edit')->name('post.edit')->middleware('PostMiddleware');
	Route::get('post','Post\PostController@index')->name('post.index');
	Route::delete('post/destroy/{id}','Post\PostController@destroy')->name('post.destroy')->middleware('PostMiddleware');
	Route::post('post/update/{id}','Post\PostController@update')->name('post.update')->middleware('PostMiddleware');

	Route::post('comment/store','Front\CommentController@store')->name('comment.store');
});
	Route::get('comment/store','Front\CommentController@getCommentParent')->name('comment.loadCommentParent');
	Route::get('comment/dfsdf','Front\CommentController@getCommentParentMore')->name('comment.loadCommentParentMore');
	Route::get('comment/fssfsfdf','Front\CommentController@getCommentChildMore')->name('comment.loadCommentChildMore');
