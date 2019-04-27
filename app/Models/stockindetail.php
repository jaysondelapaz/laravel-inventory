<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // add this for delete purpose

class stockindetail extends Model
{
   use SoftDeletes; //add this method to make softdelete working
   
	// protected $fillable= [
	// 	'product_id','productname','supplier_id','suppliername'
	// ];

 	public function product()
 	{
 		return $this->hasOne(product::class, 'id','product_id');
 	}
}
