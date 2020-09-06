<?php

namespace MagicWizardBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Test extends WebTestCase
{
	public function testGetForm()
	{
		$client = static::createClient();
		$client->request('GET', '/test/form');
		$this->assertEquals(200, $client->getResponse()->getStatusCode());
	}

	public function testPostForm()
	{
		$client = static::createClient();
		$client->request('POST', '/test/form');
		$this->assertEquals(200, $client->getResponse()->getStatusCode());
	}
}
