<?php

namespace Promani\MagicWizardBundle\Controller;

use Promani\MagicWizardBundle\Model\Flow;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractStepController extends AbstractController
{
	abstract public static function getFlowClass(): string;

	private function getFlow(): Flow
	{
		$class = $this->getFlowClass();
		return new $class();
	}

	public static function getTemplate(): string
	{
		return 'form.html.twig';
	}

	/**
	 * @Route(name="index")
	 */
	public function index(): Response
	{
		return $this->render('index.html.twig');
	}

	/**
	 * @Route("/form", name="form")
	 */
    public function form(SessionInterface $session, Request $request, $_route): Response
    {
	    $flow = $this->getFlow();
        $data = $session->get('data', []);
        $last = $session->get('steps') ? $session->get('steps')[0] : null;
        $step = $flow->getNextSteps($last);
        if (!$step || $step->getFormType()) {
	        return $this->end($step);
        }
	    $form = $this->createForm($step->getFormType(), $data);
	    $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
	        $data = array_merge($data, $form->getData());
            $session->set('data', $data);
            $steps = $session->get('steps', []);
	        array_push($steps, $step);
            $session->set('steps', $steps);
            if ($step->getCallback()) {
	            call_user_func($step->getCallback(), $data);
            }
            return $this->redirectToRoute($_route);
        }

        return $this->json(
	        $this->renderView($step->getTemplate() ?? $this->getTemplate(), [
		        'step' => $step,
		        'form' => $form->createView()
	        ])
        );
    }

	/**
	 * @Route("/back", name="back")
	 */
	public function back(SessionInterface $session): Response
	{
		$flow = $this->getFlow();
		$step = $flow->getPrevSteps($session->get('step'));
		$session->set('step', $step);

		return $this->redirectToRoute('form');
	}

    /**
     * @Route("/clear", name="clear")
     */
    public function clear(SessionInterface $session): Response
    {
        $session->clear();

        return $this->json([]);
    }

    private function end($step)
    {
        return $this->json([
           $this->renderView($this->getTemplate(), [
               'step' => $step,
           ])
        ]);
    }
}
