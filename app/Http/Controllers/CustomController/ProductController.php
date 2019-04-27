<?php

namespace App\Http\Controllers\CustomController;
use App\Http\Requests\ProductRequest; # need to call ProductRequest function
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\product;
use App\Models\supplier;
use App\User;
use Auth;

class ProductController extends Controller
{
    protected $data = array();

    public function __construct()
    {   
        $this->data['statuses'] = ['active'=>"Active", 'inactive'=>"Inactive"];
        $this->data['supplier'] = [''=>"Choose supplier"] + supplier::where('status','active')->pluck('name','id')->toArray();
       // dd($this->data);
        // $suppliers  = DB::table('suppliers')->pluck('id','name');
        //$this->data['supplier'] = supplier::orderBy('updated_at','desc')->get();
        //$suppliers = ['0'=>'Select supplier']  + collect($suppliers)->toArray();
        //dd($this->data);
        //return view('layout._pages.product.create', ['supplierss'=>$supplier_list]);
    }
        
    public function index()
    {
        $this->data['All_products'] = product::orderBy('updated_at', 'desc')->get();
        return view('layout._pages.product.index', $this->data);
        //$get_all_products = DB::table('products')->orderBy('updated_at','desc')->get();
    	//return view('layout._pages.product.index',['All_products'=> $get_all_products]);
    }

    public function create()
    {
    	return view('layout._pages.product.create', $this->data);
    }

    public function store(ProductRequest $request)
    {
        $product = new product;
        $product->fill($request->all());
     
        $product->save();

        session()->flash('msg','New product has been added.');
        return redirect()->route('Backend.product.index');
    }

    // public function edit($id = 0)
    // {
    //     $product =product::find($id);
    //     $this->data = $product;
    //     return view('layout._pages.product.edit',$this->data);

    // }

    public function edit($id)
    {
       
        $product = product::find($id);
        if($product)
        {
             $this->data['products'] = $product;
             return view('layout._pages.product.edit', $this->data);
        }
        else
        {
            return redirect()->route('Backend.error_not_found');
        }
       
    }

    public function update(ProductRequest $request,$id=0)
    {
        $product = product::find($id);
        if($product)
        {
             $product->fill($request->all());
             $product->save();
             session()->flash('msg','Successfully updated.');
              return redirect()->route('Backend.product.index');
        }
        else
        {
            return redirect()->route('Backend.error_not_found');
        }
       
    }

    public function destroy($id)
    {
    
        $product= product::find($id);
        $session_user_id = Auth::user()->id;
        $product->session_user_id = $session_user_id;
        $product->save();
        $product->delete();
         // session()->flash('msg','Deleted successfully');
         return redirect()->route('Backend.product.index');
    }


    public function trash()
    {
        $this->data['trashed'] = product::onlyTrashed()->orderBy('deleted_at',"desc")->get();
        return view('layout._pages.product.trash',$this->data);
    }

 
    public function restore($id)
    {     
        $product = product::onlyTrashed()->find($id);
        $product->session_user_id = 0;
        $product->save();   
        $restore = product::onlyTrashed()->where('id',$id)->restore();
        return redirect()->route('Backend.product.index');
        // if($restore)
        // {
        //     session()->flash('msg',"Success!, data has been restored");
        //     return redirect()->route('Backend.product.index');
        // }
        // else
        // {
        //     session()->flash('error_msg',"ERROR while trying to restore the data");
        //     return redirect()->route('Backend.product.index');
        // }
    }

}
