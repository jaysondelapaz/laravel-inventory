<?php

namespace App\Http\Controllers\CustomController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\physicalcount;
use App\User;
use Auth,PDF;

class InventoryController extends Controller
{
    protected $data = array();

    public function index()
    {
    	$this->data['stocks'] = physicalcount::orderBy('qty','desc')->get();
    	return view('layout._pages.inventory.index',$this->data);
    }

    public function pdfReport()
    { 
    	$this->data['stocks'] = physicalcount::orderBy('qty','desc')->get();
    	$pdf = PDF::loadView('layout._pages.pdf.inventory',$this->data);
    	return $pdf->stream("inventory.pdf");
    }
}
