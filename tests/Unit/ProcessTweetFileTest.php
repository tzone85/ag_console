<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProcessTweetFileTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_process_tweet_file_command()
    {


//        $this->assertTrue(true);
        $this->artisan('tweet:import ../testFiles/user.txt ../testFiles/tweets.txt')
			->expectsQuestion('Does tweet file exist', 'tweet.txt')
			->expectsQuestion('Does user file exist', 'user.txt')
			->expectsQuestion('location of first file arg1', '../testFiles/user.txt')
			->expectsQuestion('location of second file arg2', '../testFiles/tweets.txt')
			->expectsOutput('Alan> If you have a procedure with 10 parameters, you probably missed some.
									Ward> There are only two hard things in Computer Science: cache invalidation, naming things and off-by-1 errors. 
									Alan> Random numbers should not be generated with a method chosen at random.');

    }
}
