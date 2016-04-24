<?php

namespace Wise\FacebookBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Facebook\FacebookSession;

class ConfigureFacebookSessionListener
{
	protected $appId;

	protected $appSecret;

	public function __construct($appId, $appSecret)
	{
		$this->appId = $appId;
		$this->appSecret = $appSecret;
	}

	public function onKernelRequest(GetResponseEvent $event)
	{	
		// Configure FB app id and secret
		FacebookSession::setDefaultApplication($this->appId, $this->appSecret);
		// Start the PHP session manually
		$event->getRequest()->getSession()->start();
	}
}
