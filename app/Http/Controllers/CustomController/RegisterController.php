<?php

namespace App\Http\Controllers\CustomController;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest; # need to include to call RegisterRequest class
use App\Http\Controllers\Controller;
use App\User;
use Auth;
class RegisterController extends Controller
{
    public function ShowRegisterForm()
    {
    	return view('register');
    }

    public function StoreUser(RegisterRequest $request)
    {
    	$user = new User;	
    	$user->fill($request->all());
    	$user->password = bcrypt($request->password);
    	$user->save();
         //$insert = User::create(request(['email','username',$password]));
    	//dd($user);

    	#redirect to homepage after successfully regitered
    	if(Auth::check())
    	{
    		session()->flash('msg','Successfully Registerd!');
    		return redirect()->route('Backend.dashboard');
    	}
    	else
    	{
    		return "Oops! there's something wrong..";
    	}

    }
}
