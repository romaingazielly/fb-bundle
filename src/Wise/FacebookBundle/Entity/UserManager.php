<?php

namespace Wise\FacebookBundle\Entity;

use Wise\FacebookBundle\Facebook\FacebookAuthenticator;
use Wise\FacebookBundle\Facebook\FacebookClient;

class UserManager
{
	/** @var FacebookAuthenticator */
	protected $authenticator;

	public function __construct(FacebookAuthenticator $authenticator)
	{
		$this->authenticator = $authenticator;
	}

	public function getFacebookUser()
	{
        $client = FacebookClient::fromAuthenticator($this->authenticator);

        return $client->getUserFromSession();
	}
}
