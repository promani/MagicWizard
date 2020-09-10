<?php

namespace MagicWizardBundle\Model;

abstract class RestApiStep extends Step
{
	protected $method = 'POST';
	protected $url = 'url';
	protected $resource = 'resource';
	protected $client;

	public function getCallback()
	{
		return function ($data) {
			$url = $this->endpoint . $this->resource;
			$postvars = http_build_query($data);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, count($data));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
			curl_exec($ch);
			curl_close($ch);
		};
	}

}
