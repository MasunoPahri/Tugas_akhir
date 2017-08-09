<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('test', 'WelcomeController@test');

//GENERAL ROUTING
Route::get('form/{state}', 'dasborController@formState');

Route::get('logout', 'dasborController@logout');

Route::group(['prefix' => 'API'], function(){
	
	Route::get('projects/{state}', [
		'uses' => 'apiController@createProject'
	]);

	Route::get('myprofile/{token}', [
		'uses' => 'apiController@myprofile'
	]);

	Route::get('list-portofolio/', [
		'uses' => 'apiController@list_portofolio'
	]);

	Route::get('tailor-list/', [
		'uses' => 'apiController@tailors'
	]);

	Route::get('list-project/{mode}/{token}', [
		'uses' => 'apiController@projects'
	]);

	Route::get('invoices/{token}', [
		'uses' => 'apiController@invoices'
	]);

	Route::get('view-profile/{mode}/{tailor_id}', [
		'uses' => 'apiController@view_tailorProfile'
	]);

	Route::get('project-detail/{mode}/{project_id}', [
		'uses' => 'apiController@project_detail'
	]);
	
	Route::get('bid-list/{project_id}', [
		'uses' => 'apiController@bid_list'
	]);
	
	Route::get('invoice-form/{project_id}', [
		'uses' => 'apiController@invoiceForm'
	]);

	Route::post('publishProject/{project_id}', [
		'uses' => 'apiController@publishProject'
	]);

	Route::post('changePassword/{token}', [
		'uses' => 'apiController@changePassword'
	]);

	Route::post('changeImageProfile/{token}', [
		'uses' => 'apiController@changeImageProfile'
	]);

	Route::post('editProfile/{token}', [
		'uses' => 'apiController@edit_profile'
	]);

	Route::post('choose-worker', [
		'uses' => 'apiController@theBidder'
	]);

	Route::post('sendConfirm', [
		'uses' => 'apiController@sendConfirm'
	]);

	Route::post('sendTestimonial/{token}', [
		'uses' => 'apiController@sendTestimoni'
	]);

	Route::post('sendReture/{token}/{idp}', [
		'uses' => 'apiController@sendReture'
	]);

	Route::post('report-tailor', [
		'uses' => 'apiController@report_tailor'
	]);

});

Route::group(['prefix' => 'adminpanel'],function(){
	Route::get('login', [
		'uses' => 'adminController@login'
	]);

	Route::group(['middleware' => 'admin'],function(){
		Route::get('home', [
			'uses' => 'adminController@home'
		]);

		Route::get('users', [
			'uses' => 'adminController@users'
		]);

		Route::get('testimonials/{mode}', [
			'uses' => 'testimoniController@view'
		]);

		Route::get('up_testimoni/{idt}', [
			'uses' => 'testimoniController@publish'
		]);

		Route::get('dlt_testimoni/{idt}', [
			'uses' => 'testimoniController@delete'
		]);

		Route::get('bills', [
			'uses' => 'adminController@bills'
		]);

		Route::get('dltuser/{user_id}', [
			'uses' => 'adminController@dlt_user'
		]);
		
		Route::get('src-user/{string}', [
			'uses' => 'adminController@search_user'
		]);

		Route::post('sendString', [
			'uses' => 'adminController@sendString'
		]);

		Route::post('invoice/confirmed', [
			'uses' => 'billingController@confirmed'
		]);

		Route::post('invoice/sendConfirm', [
			'uses' => 'billingController@store'
		]);
	});

});
	
Route::get('block/{mode}/{user}', [
	'uses' => 'penggunaController@block'
]);
	
Route::post('block/{mode}/{user}', [
	'uses' => 'penggunaController@block'
]);

Route::group(['prefix' => '{prefixMode}'], function(){

	Route::post('login', [
		'uses' => 'dasborController@doLogin'
	]);
	
	Route::post('storeProjectMobile', [
		'uses' => 'apiController@storeProject'
	]);

	Route::post('register', 'penggunaController@doRegister');

	Route::get('dasbor/{role}', [
		'middleware' => 'checkSession',
		'uses' => 'dasborController@index'
	]);


	Route::post('editProfile/{user}', [
		'uses' => 'penggunaController@editProfile'
	]);

	Route::post('changePassword/{user}', [
		'uses' => 'penggunaController@changePassword'
	]);

	Route::post('changeImageProfile/{user}', [
		'uses' => 'penggunaController@changeImageProfile'
	]);

	//ROUTING PENJAHIT
	Route::group(['middleware' => 'penjahit'], function(){
		Route::get('allProjects', [
			'uses' => 'projectController@allProjects'
		]);
	});

	Route::get('projects/{name}', [
		'middleware' => 'checkSession',
		'uses' => 'projectController@projects'
	]);

	Route::get('project/finished/{idp}', [
		'middleware' => 'checkSession',
		'uses' => 'projectController@finished'
	]);

	Route::get('makebid/{idp}', [
		'middleware' => 'checkSession',
		'uses' => 'bidController@makeBid'
	]);

	Route::post('bid/{idp}', [
		'middleware' => 'checkSession',
		'uses' => 'bidController@bid'
	]);

	Route::get('changeBidPrice/{idp}', [
		'middleware' => 'checkSession',
		'uses' => 'bidController@changeBidPrice'
	]);

	Route::post('bidPriceChanged', [
		'middleware' => 'checkSession',
		'uses' => 'bidController@bidPriceChanged'
	]);

	Route::get('bidDone/{idp}', [
		'middleware' => 'checkSession',
		'uses' => 'bidController@bidDone'
	]);

	Route::get('portofolio/{mode}',[
		'middleware' => 'checkSession',
		'uses' => 'portofolioController@index'
	]);

	Route::post('portofolio/{mode}',[
		'middleware' => 'checkSession',
		'uses' => 'portofolioController@index'
	]);

	//ROUTING KONSUMEN
	Route::group(['middleware' => 'konsumen'], function(){
		Route::get('block/{mode}', [
			'uses' => 'penggunaController@block'
		]);

		//utk testing
		Route::get('uploads/{params}', [
			'uses' => 'projectController@uploads'
		]);

		Route::get('projects/{status}/{page}', [
			'uses' => 'projectController@userProjects'
		]);

		Route::get('project/publish/{idp}', [
			'uses' => 'projectController@publishProject'
		]);

		Route::post('uploads/{params}', [
			'uses' => 'projectController@uploads'
		]);

		Route::get('project/{mode}', [
			'uses' => 'projectController@create'
		]);

		Route::post('project/{mode}', [
			'uses' => 'projectController@create'
		]);

		Route::post('storeProject', [
			'uses' => 'projectController@store'
		]);
		
		Route::post('uploadDesign/{sizeMode}', [
			'uses' => 'projectController@saveImages'
		]);

		Route::get('tailors', [
			'uses' => 'penggunaController@tailorList'
		]);
		
		Route::get('bid-list/{idp}', [
			'uses' => 'bidController@bidList'
		]);

		Route::get('choose/{mode}', [
			'uses' => 'projectController@theBidders'
		]);

		Route::post('choose/{mode}', [
			'uses' => 'projectController@theBidders'
		]);

		Route::get('price-bid/{idp}', [
			'uses' => 'bidController@priceBid'
		]);

		Route::get('invoice/list', [
			'uses' => 'billingController@index'
		]);

		Route::get('invoice/confirm/{idp}', [
			'uses' => 'billingController@create'
		]);

		Route::post('invoice/sendConfirm', [
			'uses' => 'billingController@store'
		]);

		Route::get('testimonials/{mode}', [
			'uses' => 'testimoniController@testimonials'
		]);

		Route::post('testimonials/{mode}', [
			'uses' => 'testimoniController@testimonials'
		]);

		Route::post('reture/{idp}', [
			'uses' => 'projectController@reture'
		]);

		Route::post('report-tailor', [
			'uses' => 'penggunaController@report_tailor'
		]);

		Route::get('portofolio-search/{string}', [
			'uses' => 'portofolioController@showPortofolio'
		]);

		Route::post('portofolio-search', [
			'uses' => 'portofolioController@sendSearchString'
		]);
	});

	Route::get('profile/{user}', [
		'middleware' => 'checkSession',
		'uses' => 'penggunaController@viewProfile'
	]);

	Route::get('view-detail/{mode}/{idp}', [
		'middleware' => 'checkSession',
		'uses' => 'projectController@viewDetail'
	]);

});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);