<?php

namespace MagicWizardBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Test extends WebTestCase
{
	public function test()
	{
		$client = static::createClient();
		$client->request('GET', '/test');
		$this->assertEquals(200, $client->getResponse()->getStatusCode());
	}

	public function testGetForm()
	{
		$client = static::createClient();
		$client->request('GET', '/test/form');
		$this->assertEquals(200, $client->getResponse()->getStatusCode());
	}

	public function testPostForm()
	{
		$client = static::createClient();
		$client->request('POST', '/test/form', ['step1' => ['name' => 'john', 'email' => 'john@example.com', 'age' => 15]]);
		$this->assertEquals(200, $client->getResponse()->getStatusCode());
	}
}
