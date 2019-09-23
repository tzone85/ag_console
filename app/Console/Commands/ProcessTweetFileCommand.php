<?php

namespace App\Console\Commands;

use App\Models\Tweet;
use App\Models\TwitterUser;
use Illuminate\Console\Command;

class ProcessTweetFileCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'tweet:import {--path=}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Import tweets from text file ';

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
		$path = $this->option('path');
		$string = file_get_contents($path);

		$lines = explode("\n", $string);
		$tweets = [];

		foreach ($lines as $index => $line) {
			list($name, $tweet) = explode(">", $line);

			$user = TwitterUser::where('name', trim($name))->first();
			$user->tweets()->create(['tweet' => trim($tweet)]);
			$user->save();
			array_push($tweets, $user->with('tweets')->first());
		}

	}
}
