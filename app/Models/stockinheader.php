<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes; // add this for delete purpose

class stockinheader extends Model
{
	use SoftDeletes; //add this method to make softdelete working

    public function encoder()
    {
    	return $this->hasOne(User::class,'id','user_id');
    	//return $this->hasOne('App\User','id','user_id');
    }

    public function admin()
    {
    	return $this->hasOne(User::class, 'id','admin_user_id');
    }
}
