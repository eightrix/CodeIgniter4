<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\Response;
use Config\Services;
use CodeIgniter\Honeypot\Exceptions\HoneypotException;
use CodeIgniter\Honeypot\Honeypot;

class Honeypot implements FilterInterface
{

	/**
	 * Checks if Honeypot field is empty; if not
	 * then the requester is a bot
	 *
	 * @param CodeIgniter\HTTP\IncomingRequest $request
	 *
	 * @return mixed
	 */
	public function before(IncomingRequest $request)
	{
		$honeypot = new Honeypot(new \Config\Honeypot());
		if ($honeypot->hasContent($request))
		{
			throw HoneypotException::isBot();
		}
	}

	/**
	 * Attach a honypot to the current response.
	 *
	 * @param CodeIgniter\HTTP\IncomingRequest $request
	 * @param CodeIgniter\HTTP\Response $response
	 * @return mixed
	 */
	public function after(IncomingRequest $request, Response $response)
	{
		$honeypot = new Honeypot(new \Config\Honeypot());
		$honeypot->attachHoneypot($response);
	}

}
