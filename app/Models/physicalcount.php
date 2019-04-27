<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class physicalcount extends Model
{
	

	public function product()
	{
	   	return $this->hasOne(product::class,'id','product_id');
	}
}
