<?php

/**
* @package   s9e\TextFormatter
* @copyright Copyright (c) 2010-2016 The s9e Authors
* @license   http://www.opensource.org/licenses/mit-license.php The MIT License
*/
namespace s9e\TextFormatter\Configurator\Helpers\Http\Clients;

use s9e\TextFormatter\Configurator\Helpers\Http\Client;

class Curl extends Client
{
	/**
	* @var resource cURL handle, shared across instances
	*/
	protected static $handle;

	/**
	* {@inheritdoc}
	*/
	public function get($url, $headers = [])
	{
		$handle = $this->getHandle();
		curl_setopt($handle, CURLOPT_HTTPGET,    true);
		curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($handle, CURLOPT_TIMEOUT,    $this->timeout);
		curl_setopt($handle, CURLOPT_URL,        $url);

		return curl_exec($handle);
	}

	/**
	* {@inheritdoc}
	*/
	public function post($url, $headers = [], $body = '')
	{
		$headers[] = 'Content-Length: ' . strlen($body);

		$handle = $this->getHandle();
		curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($handle, CURLOPT_POST,       true);
		curl_setopt($handle, CURLOPT_POSTFIELDS, $body);
		curl_setopt($handle, CURLOPT_TIMEOUT,    $this->timeout);
		curl_setopt($handle, CURLOPT_URL,        $url);

		return curl_exec($handle);
	}

	/**
	* Return a globally cached cURL handle
	*
	* @return resource
	*/
	protected function getHandle()
	{
		if (!isset(self::$handle))
		{
			self::$handle = $this->getNewHandle();
		}

		return self::$handle;
	}

	/**
	* Create and return a new cURL handle
	*
	* @return resource
	*/
	protected function getNewHandle()
	{
		$handle = curl_init();
		curl_setopt($handle, CURLOPT_ENCODING,       '');
		curl_setopt($handle, CURLOPT_FAILONERROR,    true);
		curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

		return $handle;
	}
}