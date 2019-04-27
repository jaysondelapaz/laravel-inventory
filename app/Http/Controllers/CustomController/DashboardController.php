<?php

namespace App\Http\Controllers\CustomController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\physicalcount;
use App\Models\stockinheader;
use App\Models\stockoutheader;
use Carbon,DB,Helper;
class DashboardController extends Controller
{
  
    protected $data = array();

    public function monthlyReport($month)
    {
        $currentYear = date(Carbon::now()->format('Y'));
        $currentMonth = date(Carbon::now()->format('m'));
       
        //$inventory = physicalcount::whereYear('created_at','=',$currentYear)->sum('qty');
        $stockin = stockinheader::whereYear('created_at','=',$currentYear)->whereMonth('created_at','=',$month)->where('status',"posted")->sum('total_qty');
        $stockout = stockoutheader::whereYear('created_at','=',$currentYear)->whereMonth('created_at','=',$month)->where('status','posted')->sum('total_qty');

        if($currentMonth == $month)
        {
             $inventory= physicalcount::whereYear('created_at','=',$currentYear)->whereMonth('created_at','=',3)->sum('qty');
        }
        else
        {
            $inventory =null;
        }
        $data = ['a'=>$inventory,'b'=>$stockin,'c'=>$stockout];
        //json_encode(array_count_values($data));
        return $data;
    }


    public function index()
    {

    $Products = DB::table('products as product')
      ->select("product.productname","product.price","supplier.name")
      ->join("suppliers as supplier","product.supplier_id","=","supplier.id")
      ->where("supplier.status", "=", "active")->orderBy("product.created_at","desc")->paginate(5);
      $this->data['Products']= $Products;

      $this->data['january'] = $this->monthlyReport(1);
      $this->data['february'] = $this->monthlyReport(2);
      $this->data['march'] = $this->monthlyReport(3);
      $this->data['april'] = $this->monthlyReport(4);
      $this->data['may'] = $this->monthlyReport(5);
      $this->data['june'] = $this->monthlyReport(6);
      $this->data['july'] = $this->monthlyReport(7);
      $this->data['august'] = $this->monthlyReport(8);
      $this->data['september'] = $this->monthlyReport(9);
      $this->data['october'] = $this->monthlyReport(10);
      $this->data['november'] = $this->monthlyReport(11);
      $this->data['december'] = $this->monthlyReport(12);



      // $currentYear = date(Carbon::now()->format('Y'));
      // $currentMonth = date(Carbon::now()->format('m'));
      // $this->data['inventory'] = physicalcount::whereYear('created_at','=',$currentYear)->whereMonth('created_at','=',$currentMonth)->get()->sum('qty');
        //return $inventory;
   	// 	//Overall total stocks in physical inventory
    // 	$sum  = 0;
    // 	$total_stocks= physicalcount::orderBy('qty','desc')->get();
    // 	foreach($total_stocks as $index => $tot_stocks)
    // 	{
    // 		$sum += $tot_stocks->qty;
    // 	}
    // 	$this->data['total_in_stocks'] = $sum;

    // 	//Total stockin
    // 	$sum_stockin=0;
    // 	$stockins = stockinheader::orderBy('total_qty','desc')->get();
    // 	foreach ($stockins as $index => $stockin) {
    // 		$sum_stockin += $stockin->total_qty;
    // 	}
    // 	$this->data['total_stockin'] = $sum_stockin;

    // 	$sum_stockout =0;
    // 	$stockouts = stockoutheader::orderBy('total_qty','desc')->get();
    // 	foreach ($stockouts as $index => $stockout)
    // 	{
    // 		$sum_stockout += $stockout->total_qty;
    // 	}
    // 	$this->data['total_stockout'] = $sum_stockout;
    // 	return view('layout._pages.dashboard',$this->data);

    	//what im screw up 
        // $this->data['total_in_stocks'] = 0;
        // $this->dta['total_stockins'] =0;
        // $this->data['total_stockout'] = 0;
         
        $this->data['date_today'] = Carbon::now()->format('Y-m-d');
       //$this->data['date_today'] = Helper::date_db(Carbon::now()); //Helper date
       
    	$this->data['total_in_stocks'] = physicalcount::sum('qty'); //actual stocks
      $this->data['total_stockin'] = stockinheader::where('status','posted')->sum('total_qty'); // total stockin
      $this->data['total_stock_out'] = stockoutheader::where('status','posted')->sum('total_qty'); //total stockout

        //stockin today it must be posted
        $this->data['total_stockins'] = stockinheader::whereRaw("DATE(updated_at) = '{$this->data['date_today']}'")->where('status','posted')->sum('total_qty');
        
        //stockout to day is must be posted
        $this->data['total_stockout'] = stockoutheader::whereRaw("DATE(updated_at) = '{$this->data['date_today']}'")->where('status','posted')->sum('total_qty');
    	return view('layout._pages.dashboard',$this->data);
    }


}
