<?php

namespace Wise\FacebookBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Wise\FacebookBundle\Facebook\FacebookClient;

class CoreController extends Controller
{
    /**
     * @Route("/_entrypoint", name="wise_facebook_entrypoint")
     */
    public function entryPointAction()
    {
    	$authenticator = $this->container->get('wise_facebook.facebook_authenticator');

        if (!$authenticator->loadSessionFromRedirect()) {

            $target = $authenticator->getOAuthRedirectResponse(
                $this->getRequest()->getUri()
            )->getTargetUrl();

            return new Response('<html><body><script>window.top.location.href="'.$target.'";</script></body></html>');
        }

        $detect = new \Mobile_Detect();

        $url = $this->container->getParameter('wise_facebook_app_desktop_url');

        if ($detect->isMobile()) {
            $url = $this->container->getParameter('wise_facebook_app_mobile_url');
        }

        return $this->redirect($url);
    }

    /**
     * @Route("/_from_share/{from}", name="wise_facebook_share")
     */
    public function shareAction($from)
    {
        return $this->render('WiseFacebookBundle:Core:share.html.twig');
    }
}
