<?php

namespace MagicWizardBundle\Controller;

use MagicWizardBundle\Model\Flow;
use MagicWizardBundle\Model\Step;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

abstract class AbstractStepController extends AbstractController
{
    abstract public static function getFlowClass(): string;

    private function getFlow(): Flow
    {
        $class = $this->getFlowClass();
        return new $class();
    }

    protected static function getTemplate(): string
    {
        return '@MagicWizard/form.html.twig';
    }

    /**
     * @Route(name="index")
     */
    public function index(): Response
    {
        return $this->render('@MagicWizard/index.html.twig');
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
        if (!$step || !$step->getFormType()) {
            return $this->end($step);
        }
        if ($last && $last->hasToSkip($data)) {
            $this->updateStep($session, $step);
            return $this->redirectToRoute($_route);
        }
        $form = $this->createForm($step->getFormType(), $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = array_merge($data, $form->getData());
            if ($step->getCallback()) {
                try {
	                call_user_func_array ($step->getCallback(), [$data, $this->container]);
                } catch (\Exception $exception) {
                    if (!$step->isAllowFail()) {
                        return $this->json($exception->getMessage(), 404);
                    }
                }
            }
            $session->set('data', $data);
            $this->updateStep($session, $step);
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

    private function updateStep(SessionInterface $session, Step $step)
    {
        $steps = $session->get('steps', []);
        array_push($steps, $step);
        $session->set('steps', $steps);
    }

    private function end($step)
    {
        return $this->json(
            $this->renderView($this->getTemplate(), [
               'step' => $step,
           ])
        );
    }
}
