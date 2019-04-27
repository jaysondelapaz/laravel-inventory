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



//Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');
Route::group(['as' => 'Backend.', ' prefix' => ''], function(){

	$this->get('logout',['as'=>'logout', 'uses' => 'CustomController\LoginController@logout']);
	$this->get('error',['as'=>'error_not_found','uses'=>'CustomController\ErrorController@error_404']);
	#this middleware is check if you are authenticated
	$this->group(['middleware' => "custom.guest"], function(){
		
		$this->get('/',['as'=>'/','uses'=>'CustomController\LoginController@login']);
		$this->get('login',['as'=>'login', 'uses' => 'CustomController\LoginController@login']);
		$this->post('login',['as'=>'login','uses'=>'CustomController\LoginController@authenticate']);

		
	});

	#this middleware use to require you to authenticate
	$this->group(['middleware' => "custom.auth"], function(){

		$this->get('/',['as'=>'index','uses'=>'CustomController\DashboardController@index']);


		$this->group(['as'=>'product.','prefix'=>'product'], function(){
			$this->get('/',['as'=>'index','uses'=>'CustomController\ProductController@index']);
			$this->get('create',['as'=>'create','uses'=>'CustomController\ProductController@create']);
			$this->post('store', ['as' => 'store', 'uses' => 'CustomController\ProductController@store']);
			$this->get('edit/{id?}',['as'=>'edit','uses'=>'CustomController\ProductController@edit']);
			$this->post('update/{id?}',['as'=>'update','uses'=>'CustomController\ProductController@update']);
			$this->any('delete/{id?}',['as'=>'destroy','uses'=>'CustomController\ProductController@destroy']);
			$this->get('trash',['as'=>'trash','uses'=>'CustomController\ProductController@trash']);
			$this->any('restore/{id?}',['as'=>"restore",'uses'=>'CustomController\ProductController@restore']);
		});

		$this->group(['as'=>'supplier.','prefix'=>'supplier'], function(){
			$this->get('/', ['as'=>'index', 'uses'=>'CustomController\SupplierController@index']);
			$this->get('create', ['as'=>'create', 'uses'=>'CustomController\SupplierController@create']);
			$this->post('store', ['as'=>'store', 'uses'=>'CustomController\SupplierController@store']);
			$this->get('edit/{id?}',['as'=>'edit', 'uses'=>'CustomController\SupplierController@edit']);
			$this->post('update/{id?}', ['as'=>'update','uses'=>'CustomController\SupplierController@update']);
			$this->any('delete/{id?}',['as'=>'destroy','uses'=>'CustomController\SupplierController@destroy']);
			$this->get('trash',['as'=>"trash",'uses'=>'CustomController\SupplierController@trash']);
			$this->any('restore/{id?}',['as'=>'restore','uses'=>'CustomController\SupplierController@restore']);
			
		});

		$this->group(['as'=>'stockin.','prefix'=>'stockin'], function(){
			$this->get('/',['as'=>'index','uses'=>'CustomController\StockInController@index']);
			$this->get('create',['as'=>'create','uses'=>'CustomController\StockInController@create']);
			$this->get('edit/{id}',['as'=>'edit','uses'=>'CustomController\StockInController@edit']);

			$this->post('AddProduct/{id?}',['as'=>"Add-Product",'uses'=>'CustomController\StockInController@AddProduct']);
			$this->any('approve/{id?}',['as'=>"Approve",'uses'=>'CustomController\StockInController@approve']);
			$this->any('removeproduct/{id?}/{detail_id?}',['as'=>"remove_product",'uses'=>'CustomController\StockInController@removeproduct']);
			$this->any('delete/{id?}',['as'=>'destroy','uses'=>'CustomController\StockinController@destroy']);
			$this->get('{id?}.pdf',['as'=>"pdf",'uses'=>'CustomController\StockinController@pdfReport']);

			$this->get('trash',['as'=>"trash",'uses'=>'CustomController\StockinController@trash']);
		});

		$this->group(['as'=>'inventory.','prefix'=>'inventory'], function(){
			$this->get('/',['as'=>"index",'uses'=>'CustomController\InventoryController@index']);
			$this->get('stock.pdf',['as'=>"pdf",'uses'=>'CustomController\InventoryController@pdfReport']);
		});

		$this->group(['as'=>'stockout.','prefix'=>'stockout'], function(){
			$this->get('/',['as'=>"index",'uses'=>'CustomController\StockoutController@index']);
			$this->get('create',['as'=>"create",'uses'=>'CustomController\StockoutController@create']);
			$this->get('edit/{id?}',['as'=>"edit",'uses'=>'CustomController\StockoutController@edit']);
			$this->post('AddProduct/{id?}',['as'=>"Add-Product",'uses'=>'CustomController\StockoutController@AddStockout']);
			$this->any('removeproduct/{id?}/{detail_id?}',['as'=>"remove-product",'uses'=>'CustomController\StockoutController@remove_product']);
			$this->any('Approve/{id?}',['as'=>"approve",'uses'=>'CustomController\StockoutController@Approve']);
			$this->any('delete/{id?}',['as'=>"destroy",'uses'=>'CustomController\StockoutController@destroy']);
			$this->get('{id?}.pdf',['as'=>"pdf",'uses'=>'CustomController\StockoutController@pdfReport']);

			$this->get('trash',['as'=>"trash",'uses'=>'CustomController\StockoutController@trash']);
		});


		$this->group(['as'=>'account.','prefix'=>'account'], function(){
			$this->get('/',['as'=>'index','uses'=>'CustomController\AccountController@index']);
			$this->get('create',['as'=>'create','uses'=>'CustomController\AccountController@create']);
			$this->post('store',['as'=>'store','uses'=>'CustomController\AccountController@store']);
			$this->get('edit/{id?}',['as'=>"edit",'uses'=>'CustomController\AccountController@edit']);
			$this->post('update/{id?}',['as'=>"update",'uses'=>'CustomController\AccountController@update']);
			$this->any('destroy/{id?}',['as'=>"delete",'uses'=>'CustomController\AccountController@destroy']);

			$this->get('trash',['as'=>"trash",'uses'=>'CustomController\AccountController@trash']);
			$this->any('restore/{id?}',['as'=>"restore",'uses'=>'CustomController\AccountController@restore']);
		});

	}); //end of authentication middleware


	

});


 
#this middleware use require you to authenticate
// Route::group(['middleware' => "custom.auth"], function(){
// 	// Route::get('/','CustomController\LoginController@dasboard');
// 	// Route::get('dashboard', 'CustomController\LoginController@dashboard');
// 	$this->get('logout','CustomController\LoginController@logout');
// 	// $this->get('/','CustomController\LoginController@dashboard');
// 	// $this->get('dashboard', 'CustomController\LoginController@dashboard');

// 

// 	//$this->get('home','CustomController\DashboardController@home');
// 	$this->get('product','CustomController\ProductController@ProductList');
// 	$this->get('product','CustomController\ProductController@CreateProduct');
// });

	
	


	
