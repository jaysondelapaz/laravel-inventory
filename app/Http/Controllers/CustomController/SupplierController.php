<?php

namespace App\Http\Controllers\CustomController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Models\supplier;
use Auth,DB;

class SupplierController extends Controller
{
    protected $data  = array();

    public function __construct()
    {
       // $this->data['stat'] = ['active' => "Active", 'inactive'=>"Inactive"];
         $this->data['statuses'] = ['active'=>"Active", 'inactive'=>"Inactive"];

    }

    public function index()
    {
        $this->data['suppliers'] = Supplier::orderBy('updated_at', "desc")->get();
        return view('layout._pages.supplier.index', $this->data);
    	// $get_all_Suppliers = DB::table('suppliers')->orderBy('updated_at','desc')->get();
    	// return view('layout._pages.supplier.index',['AllSuplliers'=> $get_all_Suppliers]);
    }

    public function create()
    {
    	//return view('layout._pages.supplier.create');
    	return view('layout._pages.supplier.create');
    }

    public function store(SupplierRequest $request)
    {
    	$supplier = new supplier;
    	$supplier->fill($request->all());
    	$supplier->save();

    	session()->flash('msg','New Supplier Added!');
    	return redirect()->route('Backend.supplier.index');
    }

    public function edit($id=0)
    {
    	$supplier= supplier::find($id);
    	if($supplier)
    	{
           $this->data['supplier'] = $supplier;
    		return view('layout._pages.supplier.edit',$this->data);
    	}
    	else
    	{
    		
    		return redirect()->route('Backend.error_not_found');
    	}
    	
    }

    public function update(SupplierRequest $request, $id)
    {
    	$supplier = supplier::find($id);

    	if($supplier)
    	{
    	$supplier->fill($request->all());   
    	$supplier->save();
    	session()->flash('msg','updated successfully');
    	return redirect()->route('Backend.supplier.index');
    	}
    	else
    	{
    		return redirect()->route('Backend.error');
    	}
    	
    }

    public function destroy($id)
    {
    	$supplier= supplier::find($id);
        $supplier->session_user_id = Auth::user()->id;
        $supplier->save();
    	$supplier->delete();
    	// session()->flash('msg','Deleted successfully');
    	return redirect()->route('Backend.supplier.index');
    }

    public function trash()
    {
        $this->data['trashed'] = supplier::onlyTrashed()->orderBy('deleted_at',"desc")->get();
        return view('layout._pages.supplier.trash',$this->data);
    }

    public function restore($id = 0)
    {   
        $supplier = supplier::onlyTrashed()->find($id);
        $supplier->session_user_id =0;
        $supplier->save();
   
        $restore = supplier::withTrashed()->where('id',$id)->restore();
        if($restore)
        {
            //session()->flash('msg',"Successfully restored supplier details.");
            return redirect()->route('Backend.supplier.index');
        }
        else
        {
            //session()->flash('error_msg',"Failed while restoring data. Please try again.");
            return redirect()->route('Backend.supplier.index');
        }
    }

  
}
