<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
class stockoutheader extends Model
{
    use SoftDeletes;

    public function encoder()
    {
    	return $this->hasOne(User::class,'id','user_id');
    }

    public function admin()
    {
    	return $this->hasOne(User::class,'id','admin_user_id');
    }
}
