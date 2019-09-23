<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    public function user(){
    	return $this->belongsTo(TwitterUser::class);
	}

    public function follower(){
    	return $this->belongsTo(TwitterUser::class);
	}
}
