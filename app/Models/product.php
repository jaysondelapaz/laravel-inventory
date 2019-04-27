<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // add this for delete purpose
use App\User;

class product extends Model
{
    //
	use SoftDeletes; //add this method to make softdelete working

    protected $fillable = [
    	'supplier_id','productname','price','status'
    ];

    public function fromsupplier()
    {
    	return $this->hasOne(supplier::class,'id','supplier_id'); //id for supplier nad supplier_id for product table
    	// return $this->hasOne('App\Models\supplier','id','supplier_id');
    }

    public function encoder()
    {
        return $this->hasOne(User::class,'id','session_user_id');
    }
}
