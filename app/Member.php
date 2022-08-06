<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public function wallet()
    {
        return $this->hasOne(\App\MemberWallet::class,'member_id');
    }
    public function transection()
    {
    	return $this->hasMany(\App\StockAssignment::class,'member_id');
    }
}
