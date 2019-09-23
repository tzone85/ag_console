<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DriverCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'drive:tweets {--user-path=} {--tweets-path=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    	$userPath = $this->option('user-path');
    	$tweetsPath = $this->option('tweets-path');
		$this->call('user:import',['--path'=>$userPath]);
		$this->call('tweet:import',['--path'=>$tweetsPath]);
		$this->call('tweet:display');

    }
}
