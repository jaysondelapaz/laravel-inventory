<?php

namespace App\Http\Controllers\CustomController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StockoutRequest;

use Auth,Carbon,Helper,DB;
use App\Models\stockoutheader;
use App\Models\physicalcount;
use App\Models\stockoutdetail;
use App\Models\supplier;
use App\Models\product;
use PDF;

class StockoutController extends Controller
{
	protected $data = array();
    //



    public function index()
    {
        $this->data['stockouts'] = stockoutheader::orderBy('status','draft')->get();
    	return view('layout._pages.stockout.index',$this->data);
    }

    public function create()
    {
        $this->data['auth'] = Auth::user(); //check session
        $current_year = Helper::date_format(Carbon::now(), 'Y'); // get the current year
        $getlastHeader = stockoutheader::orderBy('created_at',"desc")->first();
        $last_record = stockoutheader::whereRaw("YEAR(created_at) = '{$current_year}'")->count();
        
        $newStockoutHeader = new stockoutheader;
        $newStockoutHeader->code = "OUT-{$current_year}-".str_pad(++$last_record,5,"0",STR_PAD_LEFT);
        $newStockoutHeader->user_id = $this->data['auth']->id;
        $newStockoutHeader->status="draft";
        $newStockoutHeader->save();

        if(!$newStockoutHeader->save())
        {
            session()->flash('msg_error','Saving failed!, Please try again.');
            return redirect()->back();
        }

        return redirect()->route('Backend.stockout.edit',[$newStockoutHeader->id]);
    }

    public function edit($id = 0)
    {
        $header = stockoutheader::find($id);
        if($header)
        {   
            $suppliers = physicalcount::distinct('supplier_id')->get();
            $this->data['products'] = [''=>"Choose Product"];

            foreach($suppliers as $index => $supplier)
            {                                                       
                $productss = physicalcount::select(DB::raw("CONCAT(productname,' (Qty. ',qty,')')as name"),'product_id')->where('supplier_id', $supplier->supplier_id)->pluck('name','product_id');

                if($productss->count()>0)
                {
                    $this->data['products']["{$supplier->suppliername}"] = $productss->toArray();
                }    
            }

            $this->data['header'] = $header;
            $this->data['details'] = stockoutdetail::where('stock_out_header_id',$id)->get();
            return view('layout._pages.stockout.edit',$this->data);
        }
        else
        {
            return redirect()->route('Backend.error_not_found');
        }
    	
    }


    public function AddStockout(StockoutRequest $request, $id = 0)
    {
        $header = stockoutheader::find($id);
        if($header)
        {
          
            //find product in inventory
            $product = physicalcount::where('product_id', $request->get('product_id'))->first();
            if($product AND $product->qty < $request->get('qty'))
            {
                session()->flash('error_msg',"Failed transaction, Insufficient stock.");
                return redirect()->back();
            }
            //get stockout header and also the product if there's already been added
            $detail = stockoutdetail::where('product_id',$request->get('product_id'))->where('stock_out_header_id',$id)->first();
            
            if(!$detail)
            {
                $detail = new stockoutdetail;
                $detail->stock_out_header_id = $id;
                $detail->product_id = $product->product_id;
                $detail->productname = $product->productname;
                $detail->supplier_id = $product->supplier_id;
                $detail->suppliername =$product->suppliername;  
        
            }
                 $detail->qty=$request->get('qty');
                 if(!$detail->save())
                 {
                    session()->flash('error_msg',"Failed to add product, Please try again.");
                    return redirect()->back();
                 }          

                 //get total quantity in stockoutdetials
                 $stocks_qty = stockoutdetail::where('stock_out_header_id',$id)->get();
                 
                 $sum_qty = 0;
                 foreach($stocks_qty as $index => $stock)
                 {
                    $sum_qty +=$stock->qty;
                 }   
                    $header->total_qty = $sum_qty;
                    $header->save();
                    session()->flash('success_msg',"New record has been added.");
                    return redirect()->route('Backend.stockout.edit',[$header->id]);
        }
        else
        {
            return redirect()>route('Backend.error_not_found'); 
        }
    }


    public function remove_product($id = 0, $detail_id =0)
    {
        $detail = stockoutdetail::where('id',$detail_id)->where('stock_out_header_id',$id)->first();
        if($detail)
        {
            $header = stockoutheader::find($id);
            if(!$detail->delete())
            {
                session()->flash('error_msg',"Failed, Please try again");
                return redirect()->back();
            }

            //get stock details
            $stock_details = stockoutdetail::where('stock_out_header_id',$id)->get();
            $sumtotal_qty = 0;
            foreach($stock_details as $index =>$alldetails)
            {
                $sumtotal_qty += $alldetails->qty;
            }
            $header->save();
             return redirect()->route('Backend.stockout.edit',[$header->id]);
        }
        else
        {
            return redirect()->route('Backend.error_not_found');
        }
    }

    public function Approve($id=0)
    {
        $header = stockoutheader::find($id);

        if($header)
        {
            $header->status = "posted";
            $header->admin_user_id = Auth::user()->id;
            $header->save();

            $details = stockoutdetail::where('stock_out_header_id', $id)->get();
            foreach($details as $index =>$detail)
            {
                 //find product id in physical count table   
                $inventory = physicalcount::where('product_id',$detail->product_id)->first(); 
                $inventory->qty -= $detail->qty; // decrement of -- minus minus
                $inventory->save();
            }

            session()->flash('success_msg',"Stock out : {$header->code} successfully remove stock to physical inventory.");
            return redirect()->route('Backend.stockout.index');
        }
        else
        {
            return redirect()->route('Backend.error_not_found');
        }
    }

    //Void transaction
    public function destroy($id =0)
    {
        $header = stockoutheader::find($id);
        if($header)
        {
            $header->status = "cancelled";
            $header->admin_user_id = Auth::user()->id;
            $header->save();
            session()->flash('success_msg',"Success!, Transaction has been cancelled.");
            return redirect()->route('Backend.stockout.index');

        }
        else
        {   
            return redirect()->route('Backend.error_not_found');
        }
    }

    public function pdfReport($id = 0)
    {
        $header = stockoutheader::find($id);
        if($header)
        {
            $suppliers = supplier::where('status','active')->get();
            foreach($suppliers as $index => $supplier)
            {
                $products = product::where('supplier_id', $supplier->id)->pluck('productname','id');
                if($products->count() > 0)
                {
                    $this->data['products']["{$supplier->name}"] = $products->toArray();
                   
                }
            }

            $this->data['header'] = $header;
            $this->data['details']= stockoutdetail::where('stock_out_header_id',$id)->get();
            
            $pdf = PDF::loadView('layout._pages.pdf.stockout',$this->data); //locate the path of blade html to pdf
            return $pdf->stream("{$header->code}.pdf");
        }
        else
        {
            return redirect()->route('Backend.error_not_found');
        }
    }


    public function trash()
    {
        return view('layout._pages.stockout.trash',$this->data);
    }

}
