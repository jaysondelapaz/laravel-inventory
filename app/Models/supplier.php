<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // add this for delete purpose
use App\User;

class supplier extends Model
{
	use SoftDeletes; //to work with softdeletes

     protected $fillable = [
    	'name','address','status'
    ];

    public function encoder()
    {
    	return $this->hasOne(User::class,'id','session_user_id');
    }
}
