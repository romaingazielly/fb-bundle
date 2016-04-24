<?php

namespace Wise\FacebookQuizBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Wise\FacebookBundle\Facebook\FacebookClient;

/**
 * @Route("/quiz")
 */
class QuizController extends Controller
{
    /**
     * @Route("/", name="wise_facebook_quiz_index")
     */
    public function indexAction()
    {
        var_dump($this->get('wise_facebook.user_manager')->getFacebookUser()); die();
        
        return $this->render('WiseFacebookQuizBundle:Quiz:index.html.twig', array());
    }

    /**
     * @Route("/question/{number}", name="wise_facebook_quiz_question")
     */
    public function questionAction(Request $request)
    {
    	$loader = $this->get('wise_facebook_quiz.config_loader');

    	$questions = $loader->load();

    	$step = $request->get('number', 1);
    	$answer = $request->get('answer', 1);
    	$lastQuestion = $request->get('question', null);

    	if (1 == $step) {
    		$score = 0;

    		// pick random questions
	        
	        shuffle($questions);

	        $questions = array_slice($questions, 0, 5);

	        $this->container->get('session')->set('quiz_questions', $questions);
	        $this->container->get('session')->set('score', $score);
    	} else {
    		$questions = $this->get('session')->get('quiz_questions');
    		$score = $this->get('session')->get('score');
    	}

        if ($step > 1 && $lastQuestion['good'] == $answer) {
    		$score++;
    		$this->get('session')->set('score', $score);
        }

        if ($step > 5) {
    		return $this->redirect($this->generateUrl('wise_facebook_quiz_resultat'));
    	}

        $question = $questions[$step-1];

        return $this->render('WiseFacebookQuizBundle:Quiz:question.html.twig', array(
        	'step' => $step,
        	'questionNum' => ($step-1),
        	'question' => $question,
        	'score' => $score,
        ));
    }
}
