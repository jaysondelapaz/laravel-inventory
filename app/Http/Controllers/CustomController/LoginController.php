<?php

namespace App\Http\Controllers\CustomController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth,DB;
use App\Models\product;
use App\Models\supplier;
class LoginController extends Controller
{

	 
	protected $data = array();

   public function login()
   {
   	return view('login');
   }

   public function Authenticate(Request $request)
   {
   		if(Auth::attempt(['username' => $request->username, 'password' => $request->password]))
   		{
   			return redirect()->route('Backend.index');
   		}
   		else
   		{
            session()->flash('msg','Invalid username or password');
   			return redirect()->back();
   		}
   }

   
   public function logout()
   {
   	Auth::logout();
   	#return ('thank you for login');
   return redirect()->route('Backend.login');
   }
}
