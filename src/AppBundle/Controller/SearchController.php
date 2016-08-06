<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class SearchController
 * @package AppBundle\Controller
 */
class SearchController extends Controller
{

    /**
     * GET Action
     *
     * @Route("/search", name="search")
     * @Method("GET")
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Request $request
     */
    public function indexAction()
    {
        return $this->render('search/index.html.twig');
    }


    /**
     * POST Action
     *
     * @Route("/search", name="search")
     * @Method("POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postAction(Request $request)
    {
        $q = $request->get('q');
        if ($q != null && $q === "") {
            return $this->redirectToRoute('homepage');
        }

        $activities = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Activity')
            ->searchInTitle($q);

        return $this->render('search/index.html.twig',
            array('activities' => $activities)
        );
    }

}
