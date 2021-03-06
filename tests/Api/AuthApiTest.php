<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthApiTest extends ApiTestCase
{
	use DatabaseMigrations;

	/**
	 * @test
	 */
	public function it_should_allow_you_to_login()
	{
		$credentials = ['email' => 'johndoe@test.com', 'password' => 'test123'];

		factory(App\User::class)->create([
			'email' => $credentials['email'],
			'password' => Hash::make($credentials['password']),
		]);

		$this->post('/authenticate', $credentials)
			->seeStatusCode(200)
			 ->seeJsonStructure(['token']);
	}

	/**
	 * @test
	 */
	public function it_should_fail_with_wrong_credentials()
	{
		factory(App\User::class)->create();

		$this->post('/authenticate', ['email' => 'foo', 'password' => 'bar'])
			 ->seeStatusCode(401);
	}

}
