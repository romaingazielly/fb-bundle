<?php

namespace Wise\FacebookBundle\Facebook;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequestException;

class FacebookAuthenticator
{
    const SESSION_KEY = '_facebook_token';

	/** @var FacebookSession */
	protected $facebookSession;

    /** @var Session */
    protected $session;

    /** @var array */
    protected $permissions;

    /** @var boolean */
    protected $simulate;

    public function __construct(Session $session, array $permissions, $simulate = false)
    {
        $this->session = $session;
        $this->permissions = $permissions;
        $this->simulate = $simulate;
    }

	public function getOAuthRedirectResponse($redirectUrl)
    {
        $this->getSession()->set('_redirect_url', $redirectUrl);

        $helper = new FacebookRedirectLoginHelper($redirectUrl);

		return new RedirectResponse($helper->getLoginUrl($this->permissions));
    }

    public function loadSessionFromRedirect()
    {
    	$helper = new \Facebook\FacebookRedirectLoginHelper($this->getSession()->get('_redirect_url'));

        if ($this->getFacebookSession()) {
            return true;
        }

        try {
        	$facebookSession = $helper->getSessionFromRedirect();
        } catch (\Facebook\FacebookRequestException $e) {
     		throw $e;
        }

        if ($facebookSession) {
            $this->facebookSession = $facebookSession;
            $this->session->set(self::SESSION_KEY, $facebookSession->getToken());

            return true;
        }

        return false;
    }

    /**
     * Gets the value of facebookSession.
     *
     * @return mixed
     */
    public function getFacebookSession()
    {
        // In local dev environement, return a faked session
        if ($this->getSimulate()) {
            return new FacebookSession(uniqid());
        }
        
        if (null === $facebookSession = $this->facebookSession) {

            if ($token = $this->session->get(self::SESSION_KEY)) {
                $storedFacebookSession = new FacebookSession($token);

                // For certain cases validate() throws a FacebookSDKException,
                // this should be removed in future versions
                try {
                    if ($storedFacebookSession->validate()) {
                        return $storedFacebookSession;
                    }
                } catch (\Exception $e) {
                    return null;
                }
            }
            
            return null;
        }

        return $this->facebookSession;
    }
    
    /**
     * Sets the value of facebookSession.
     *
     * @param mixed $facebookSession the facebook session 
     *
     * @return self
     */
    protected function setFacebookSession($facebookSession)
    {
        $this->facebookSession = $facebookSession;

        return $this;
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
    protected function setSession($session)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Gets the value of permissions.
     *
     * @return mixed
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * Sets the value of permissions.
     *
     * @param mixed $permissions the permissions
     *
     * @return self
     */
    protected function setPermissions($permissions)
    {
        $this->permissions = $permissions;

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