<?php

namespace App\Http\Controllers\CustomController;
use App\Http\Controllers\Controller as BaseController;
use Helper,Route;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $data;


    public function __construct(){
		self::set_active_route();
         

	}
    public function set_active_route()
    {
    	$this->data['routes'] = array(
    		'product' => ['product.index','product.create']

    	);

    	

    }
}
