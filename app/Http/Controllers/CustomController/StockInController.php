<?php

namespace App\Http\Controllers\CustomController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StockInRequest;
//use App\Http\Requests\ProductRequest;

use Auth,Helper;
use Carbon;
use PDF;
use App\Models\stockinheader;
use App\Models\stockindetail;
use App\Models\supplier;
use App\Models\product;
use App\Models\physicalcount;

class StockInController extends Controller
{
    protected $data = array();

    public function __construct()
    {
        $this->data['statuses'] = ['active' =>"Active",'inactive'=>"Inactive"];
        $this->data['supplier'] =[''=>"Choose Supplier"] + supplier::where('status','active')->pluck('name','id')->toArray();
    }

    public function index()
    {
    	$this->data['stockins'] = stockinheader::orderBy('status','draft')->get();
    	return view('layout._pages.stockin.index',$this->data);	
    }

    public function create()
    {
           $this->data['auth'] = Auth::user(); // check the session  
           $current_year = Helper::date_format(Carbon::now(),'Y'); //get the current year
           $getHeader = stockinheader::orderBy('created_at','desc' )->first();//get last record 
           $last_record = stockinheader::whereRaw("YEAR(created_at) = '{$current_year}'")->count();
           
           $newStockHeader = new stockinheader;
           $newStockHeader->code = "IN-{$current_year}-".str_pad(++$last_record,5,"0",STR_PAD_LEFT);
           $newStockHeader->total_qty=0;
           $newStockHeader->user_id=$this->data['auth']->id;
           $newStockHeader->status = "draft";
           $newStockHeader->save();

           if(!$newStockHeader->save())
           {
            session()->flash('msg_error',"Saving failed!, Please try again");
            return redirect()->route('Backend.stockin.index');
           }
            return redirect()->route('Backend.stockin.edit', [$newStockHeader->id]);

           #$rowCount = $this->data['last_record']->count();
           // $rowCount = count($last_record);
           // if($rowCount <= 0)
           // {
           //  $codeIncrement = "00001";
           //  $this->data['code'] = "IN-{$current_year}-".$codeIncrement;
           // }

    }

    public function edit($id)
    {
        $header = stockinheader::find($id);
        if($header)
        {
          $suppliers = supplier::where('status','active')->get();
          $this->data['products'] = [''=>"Choose Product"];

          foreach($suppliers as $index => $supplier)
          {
            $products = product::where('supplier_id',$supplier->id)->pluck('productname','id');
            //return "eto ba".$supplier->name;
            if($products->count()>0)
            {
              $this->data['products']["{$supplier->name}"] = $products->toArray();
            }
          }
        }
        else
        {
           return redirect()->route('Backend.error_not_found');
        }
        $this->data['header'] = $header;
        $this->data['details'] = stockindetail::where('stock_in_header_id', $id)->get(); //tranaction details
        return view('layout._pages.stockin.edit',$this->data);
    }

    public function AddProduct(StockInRequest $request, $id = 0)
    {
      $header = stockinheader::find($id);
      if($header)
      {
        //return $request->get('product_id'); //get the product id from selectbox
        $product = product::find($request->get('product_id'));
        $detail = stockindetail::where('product_id',$request->get('product_id'))
                                  ->where('stock_in_header_id',$id)->first();


        if(!$detail)
        {
          $detail = new stockindetail;
          $detail->stock_in_header_id=$id;
          $detail->product_id=$product->id;
          $detail->productname=$product->productname;
          $detail->supplier_id=$product->supplier_id;
          $detail->suppliername=$product->fromsupplier ? $product->fromsupplier->name : "-"; //fromsupplier is relation in product model
         
        }

       
        $detail->qty=$request->get('qty');
        if(!$detail->save())
        {
          session()->flash('msg_error','Failed while updating data. Please try again.');
          return redirect()->back();
        }


        //for existing stockin transaction 
        $stocks = stockindetail::where('stock_in_header_id', $id)->get();
        $sum_qty = 0;
        foreach($stocks as $index => $stock)
        {
          $sum_qty += $stock->qty;
        }


        $header->total_qty = $sum_qty;
        $header->save();

        session()->flash('success_msg','New record has been added.');
        return redirect()->route('Backend.stockin.edit',[$header->id]);
      }
      else
      {
        return redirect()->route('Backend.error_not_found');
      }
    }


    public function removeproduct($id=0,$detail_id=0)
    {               
      $detail = stockindetail::where('id', $detail_id)->where('stock_in_header_id',$id)->first();
      //return "is it correct" .$detail;
      if($detail)
      {
        $header = stockinheader::find($id);

        //session()->flash('success_msg',"Product stock successfully deleted.");
        if(!$detail->delete())
        {
          session()->flash('error_msg',"Failed server error while deleting record. Please try again.");
          return redirect()->back();
        }

        $stockdetails = stockindetail::where('stock_in_header_id',$id)->get(); //get remaining stock details
        $sum_qty = 0;
        foreach($stockdetails as $index => $remaining_stocks)
        {
          $sum_qty += $remaining_stocks->qty;
        }

        $header->total_qty = $sum_qty;
        $header->save();

        return redirect()->route('Backend.stockin.edit',[$header->id]);
      }
      else
      {
        session()->flash('error_msg',"Failed while removing product, Please try again");
        return back();
      }
    }


    public function approve($id = 0)
      {
        $header = stockinheader::find($id);
       
        if($header)
        {
          $header->status = "posted";
          $header->admin_user_id= Auth()->user()->id;
          $header->save();
        
        $details = stockindetail::where('stock_in_header_id',$id)->get();
        //return $details;

        foreach($details as $index => $detail)
        {
          $physicalcount = physicalcount::where('product_id', $detail->product_id)->first();
          if(!$physicalcount)
          {
            $physicalcount = new physicalcount;
            $physicalcount->product_id=$detail->product_id;
            $physicalcount->productname=$detail->productname;
            $physicalcount->supplier_id=$detail->supplier_id;
            $physicalcount->suppliername=$detail->suppliername;
            $physicalcount->qty=0;
          }

          $physicalcount->qty += $detail->qty; //no space between += sign or else you may get syntax error
          $physicalcount->save();
          if(!$physicalcount->save())
          {
            session()->flash('error_msg',"Failed to added physical inventory.");
            return redirect()->route('Backend.inventory.index');
          }
        } //end of foreach

        session()->flash('success_msg',"Stockin code: {$header->code} successfully added to physical inventory");
        return redirect()->route('Backend.inventory.index');

      }
      else
      {
        return redirect()->route('Backend.error_not_found');
      }
      
    }   


    public function destroy($id = 0)
    {
      $header = stockinheader::find($id);
      if($header)
      {
        $header->status='cancelled';
        $header->admin_user_id = Auth::user()->id;
        $header->save();
        session()->flash('msg',"Transaction has been cancelled.");
        return redirect()->route('Backend.stockin.index');
      }
      else
      {
        return redirect()->route('Backend.error_not_found');
      }
    }

    public function pdfReport($id = 0)
    {
      $header = stockinheader::find($id);
      if($header)
      {
        $suppliers = supplier::where('status','active')->get();

        foreach($suppliers as $index => $supplier)
        {
          $products = product::where('supplier_id',$supplier->id)->pluck('productname','id','price');
          if($products->count() > 0)
          {
            $this->data['products']["{$supplier->name}"] = $products->toArray();
          }
        }

          $this->data['header']= $header;
          $this->data['details'] = stockindetail::where('stock_in_header_id',$id)->get();
        
          $pdf = PDF::loadView('layout._pages.pdf.stockin', $this->data); //locate the path of pdf file page
          return $pdf->stream("{$header->code}.pdf");
      }
      else
      {
        return redirect()->route('Backend.error_not_found');
      }
    }

    public function trash()
    {
       $this->data['users'] = product::onlyTrashed()->orderBy('deleted_at', "desc")->get();
      return view('layout._pages.stockin.trash',$this->data);
    }
}
