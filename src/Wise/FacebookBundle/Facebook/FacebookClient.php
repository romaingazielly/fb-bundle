<?php

namespace Wise\FacebookBundle\Facebook;

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Wise\FacebookBundle\Entity\User;

class FacebookClient
{
	/** @var FacebookSession */
	protected $session;

	/** @var boolean */
	protected $simulate;

	public static function fromAuthenticator(FacebookAuthenticator $authenticator)
	{
		return new self($authenticator->getFacebookSession(), $authenticator->getSimulate());
	}

	public function __construct(FacebookSession $session = null, $simulate = false)
	{
		$this->session = $session;
		$this->simulate = $simulate;
	}

	public function get($path)
	{
		return (new FacebookRequest(
				  $this->getSession(), 'GET', $path
				))->execute()->getGraphObject();
	}

	public function getUserFromSession()
	{
		$user = new User();

		if ($this->getSimulate()) {
			$user->setFacebookId(md5($_SERVER['REMOTE_ADDR']));
			$user->setFirstName('Mister');
			$user->setLastName('Hyde');

			return $user;
		}

		$graphUser = $this->get('/me');

		$user->setFacebookId($graphUser->getProperty('id'));
		$user->setFirstName($graphUser->getProperty('first_name'));
		$user->setLastName($graphUser->getProperty('last_name'));

		return $user;
	}

    /**
     * Gets the value of session.
     *
     * @return mixed
     */
    public function getSession()
    {
        return $this->session;
    }
    
    /**
     * Sets the value of session.
     *
     * @param mixed $session the session 
     *
     * @return self
     */
    public function setSession($session)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Gets the value of simulate.
     *
     * @return mixed
     */
    public function getSimulate()
    {
        return $this->simulate;
    }

    /**
     * Sets the value of simulate.
     *
     * @param mixed $simulate the simulate
     *
     * @return self
     */
    protected function setSimulate($simulate)
    {
        $this->simulate = $simulate;

        return $this;
    }
}