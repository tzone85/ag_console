<?php

namespace App\Console\Commands;

use App\Models\TwitterUser;
use Illuminate\Console\Command;

class ProcessUserFileCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'user:import {--path=}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Import user from text file';

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

		$lines = explode(PHP_EOL, $string);
		$users = [];
		foreach ($lines as $index => $line) {
			list($follower, $user) = explode(' follows ', $line);
			$all = explode(', ', $user);
			array_push($all, $follower);

			foreach ($all as $u) {
				if (empty($users[trim($u)])) {
					$users[trim($u)] = [];
				}

				if ($u !== $follower) {
					if (empty($users[trim($u)]['followers'])) {
						$users[trim($u)]['followers'][] = trim($follower);
					} elseif (!empty($users[trim($u)]['followers']) && !in_array($follower, $users[trim($u)]['followers'])) {
						$users[trim($u)]['followers'][] = trim($follower);
					}
				}
			}
		}

		// Persist users to database
		foreach ($users as $user => $follower) {
			$user_model = TwitterUser::firstOrCreate(['name' => $user]);
			$users[$user]['model'] = $user_model;
		}

		// Associating followers
		foreach ($users as $user => $followers) {
			$followers['model']->followers()->detach();
			$followerList = $followers['followers'] ?? [];

			foreach (array_unique($followerList) as $follower) {
				//TwitterUser::where('name', $follower)->first()->followers()->attach($followers['model']);
				$followers['model']->followers()->attach(TwitterUser::where('name', $follower)->first());
			}
		}
	}
}
