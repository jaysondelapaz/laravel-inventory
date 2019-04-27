<?php

namespace App\Http\Controllers\CustomController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ErrorController extends Controller
{
    //
      public function error_404()
	{
		return view('layout.error.error');
	}
}
