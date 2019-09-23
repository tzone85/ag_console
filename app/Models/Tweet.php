<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
	public $fillable = ['tweet'];

	public function user()
	{
		return $this->belongsTo(TwitterUser::class);
	}
}
