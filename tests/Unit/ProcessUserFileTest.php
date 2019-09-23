<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProcessUserFileTest extends TestCase
{
	/**
	 * A basic unit test example.
	 *
	 * @return void
	 */
	public function test_process_user_command()
	{
//        $this->assertTrue(true);
		$this->artisan('user:import --arg1 ../user.txt')
			->expectsQuestion('Does user file exist', 'user.txt')
			->expectsQuestion('location of user file', '../testFile/user.txt')
			->expectsOutput('Ward follows Alan
									Alan follows Martin
									Ward follows Martin, Alan');
    }
}
