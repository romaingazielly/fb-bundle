<?php

namespace Wise\FacebookBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GameController extends Controller
{
    /**
     * @Route("/", name="wise_facebook_game_index")
     */
    public function indexAction(Request $request)
    {
        if (!$this->hasFacebookSession()) {
        	return $this->redirectToFacebookAuthentication();
        }

        if ($this->isEnded()) {
        	return $this->render('WiseFacebookBundle:Game:jeu_termine.html.twig');
        }

        return $this->render('WiseFacebookBundle:Game:index.html.twig');
    }

    public function hasFacebookSession()
    {
    	$authenticator = $this->container->get('wise_facebook.facebook_authenticator');

    	return null != $authenticator->getFacebookSession();
    }

    public function redirectToFacebookAuthentication()
    {
    	return $this->redirect($this->generateUrl('wise_facebook_entrypoint'));
    }

    public function isEnded()
    {
        if ($this->container->getParameter('wise_facebook_end_date') == null) {
            return false;
        }

        return $this->container->getParameter('wise_facebook_end_date') < date('Y-m-d H:i');
    }

    /**
     * @Route("/jeu", name="jeu")
     */
    public function jeuAction()
    {
        return $this->render('WiseFacebookBundle:Game:jeu.html.twig', array());
    }

    /**
     * @Route("/jeu_termine", name="jeu_termine")
     */
    public function jeu_termineAction()
    {
        return $this->render('WiseFacebookBundle:Game:jeu_termine.html.twig', array());
    }

    /**
     * @Route("/register", name="register")
     */
    public function register()
    {
        return $this->render('WiseFacebookBundle:Game:register.html.twig');
    }
}