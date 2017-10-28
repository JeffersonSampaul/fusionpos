<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
/*
Route::get('/', function()
{
	return View::make('welcome');
});
Route::post('/', function()
{
	return View::make('login');
});
Route::get('/login', function()
{
	return View::make('welcome');
});*/
Route::filter('logincheck', function()
{
    if (!Session::get("user"))
    {
        return Redirect::to('/');
    }else{
		$user=Session::get("user");
		$host=Session::get("host");
		$login=new Login();
		$login=$login->connect($host);
		if(!$login->where("username",$user->username)
			  ->where("password",$user->password)
		    ->first())
		 return Redirect::to('/logout');
	}
});


//------------------Login---------------------
Route::get('/','LoginController@welcomeForm');
Route::post('/', 'LoginController@validatePhone');
Route::get('/login', 'LoginController@loginForm');
Route::post('/login', 'LoginController@loginDo');
Route::get('/logout', function()
{
	Session::flush();
	return Redirect::to('/');
});
//------------------Home----------------------
Route::get('/home', array('before' => 'logincheck', 'uses' => 'OrderController@showOrders'));
Route::get('/orders', array('before' => 'logincheck', 'uses' => 'OrderController@currentOrders'));
Route::post('/loadcurrentorders', array('before' => 'logincheck', 'uses' => 'OrderController@loadcurrentOrders'));
Route::post('/neworders', array('before' => 'logincheck', 'uses' => 'OrderController@newOrders'));
Route::post('/receipt', array('before' => 'logincheck', 'uses' => 'OrderController@loadReceipt'));
Route::post('/accept', array('before' => 'logincheck', 'uses' => 'OrderController@acceptOrder'));
Route::post('/reject', array('before' => 'logincheck', 'uses' => 'OrderController@rejectOrder'));
Route::post('/hide', array('before' => 'logincheck', 'uses' => 'OrderController@hideOrder'));
Route::post('/notify', array('before' => 'logincheck', 'uses' => 'OrderController@newNotify'));
Route::get('/notify','OrderController@newNotify');
Route::get('/domain/{phone}','OrderController@listDomain');
Route::get('/print/{id}', array('before' => 'logincheck', 'uses' => 'OrderController@printOrder'));
Route::get('/map/{id}', array('before' => 'logincheck', 'uses' => 'OrderController@showMap'));

//--------OPenclose

Route::post('/openTime', array('before' => 'logincheck', 'uses' => 'OrderController@updateOpen'));

//-----------Profile---------
Route::get('/profile', array('before' => 'logincheck', 'uses' => 'OrderController@showProfile'));
Route::post('/profile', array('before' => 'logincheck', 'uses' => 'OrderController@saveProfile'));
