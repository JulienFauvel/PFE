<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{

    /**
     * Index action
     *
     * @Route("/", name="homepage")
     * @Route("/index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $activities = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Activity')
            ->getActivities(20);

        return $this->render('default/index.html.twig',
            array('activities' => $activities));
    }

}
