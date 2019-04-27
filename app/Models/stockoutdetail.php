<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // add this for delete purpose

class stockoutdetail extends Model
{
    use SoftDeletes;

   public function product()
   {
   	return $this->hasOne(product::class,'id','product_id');
   }
}
