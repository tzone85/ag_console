<?php

namespace App\Console\Commands;

use App\Models\Tweet;
use App\Models\TwitterUser;
use Illuminate\Console\Command;

class UserTweetsCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'tweet:display';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Displays a set of tweets';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$models = TwitterUser::with('follows')->get();
		$tweets = Tweet::all();
		foreach ($models as $user) {
			echo "{$user->name}\n";
			$follows = $user->follows->map(function($item){
				return $item->id;
			})->toArray();

			foreach ($tweets as $tweet) {
				if(in_array($tweet->user->id,$follows)||($tweet->user->id ===$user->id))
				//echo "/// \n";
//				if($tweet->user->name === $user->name || ($user->followers && $user->followers->($user)))
				echo "\t", "@{$tweet->user->name} {$tweet->tweet}", "\n";
			}
		}

	}
}
