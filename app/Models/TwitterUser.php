<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TwitterUser extends Model
{
	public $fillable = ['name'];
    public function followers()
	{
		return $this->belongsToMany(TwitterUser::class, 'followers','user_id', 'follower_id', 'id', 'id');
	}
    public function follows()
	{
		return $this->belongsToMany(TwitterUser::class, 'followers','follower_id','user_id',  'id', 'id');
	}

	public function tweets(){
    	return $this->hasMany(Tweet::class, 'user_id');
	}
}
