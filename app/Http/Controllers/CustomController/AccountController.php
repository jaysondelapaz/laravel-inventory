<?php

namespace App\Http\Controllers\CustomController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\User;
use Auth;
use PDF;
class AccountController extends Controller
{

	protected $data = array();

	public function __construct()
	{
		$this->data['positions'] = [''=>"Choose Job Position",'administrator'=>"Administrator",'manager'=>"Manager",'cashier'=>"Cashier"];

		$this->data['gender'] = ['male'=>"Male",'female'=>"Female"];

	}

    public function index()
    {   
        $this->data['users'] = User::where('id','<>',1)->orderBy('updated_at','desc')->get();
        //$this->data['users'] = User::orderBy('updated_at','desc')->get();
    	return view('layout._pages.account.index',$this->data);
    }

    public function create()
    {
    	return view('layout._pages.account.create',$this->data);
    }

    public function store(AccountRequest $request)
    {
        //return $request->all();
        $new_user = new User;
        $new_user->fill($request->except('password'));
        $new_user->password = bcrypt($request->get('password'));
        $new_user->save();

        if(!$new_user->save())
        {
            session()->flash('error_msg',"Saving Failed, Please try again.");
            return redirect()->route('Backend.error_not_found');
        }
        session()->flash('success_msg',"Success new user added.");
        return redirect()->route('Backend.account.index');
    }

    public function edit($id = 0)
    {
        $user = User::find($id);

        if($user)
        {
            $this->data['user'] = $user;
            return view('layout._pages.account.edit',$this->data);
        }
        else
        {
            return redirect()->route('Backend.error_not_found');
        }
    }

    public function update(AccountRequest $request,$id = 0)
    {
        $user = User::find($id);
        if($user)
        {
            $user->fill($request->except('password'));
            $user->password = bcrypt($request->get('password'));
            $user->save();
            session()->flash('success_msg',"Success, account has been updated.");
            return redirect()->route('Backend.account.index');
        }
        else
        {
            return redirect()->route('Backend.error_not_found');
        }
    }


    public function destroy($id =  0)
    {
        $user = User::find($id);
        $session_user_id = Auth::user()->id;
        $user->session_user_id = $session_user_id;
        $user->save();
        if(!$user->delete())
        {
            session()->flash('error_msg',"Failed, Please try again.");
        }
            session()->flash('success_msg',"Success account has been deleted.");
            return redirect()->route('Backend.account.index');
    }

    public function trash()
    {
        $this->data['trashed'] = User::onlyTrashed()->orderBy('deleted_at',"desc")->get();
        return view('layout._pages.account.trash',$this->data);
    }

    public function restore($id =0)
    {   
        $user = User::onlyTrashed()->find($id);
        $user->session_user_id = 0;
        $user->save();
        $restore = User::onlyTrashed()->where('id',$id)->restore();
        return redirect()->route('Backend.account.index');
    }
}
