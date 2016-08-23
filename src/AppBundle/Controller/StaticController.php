<?php


namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class StaticController extends Controller
{
    /**
     * Index action
     *
     * @Route("/confidentialite", name="confidentialite")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/confidentialite.html.twig');
    }

    /**
     * Index action
     *
     * @Route("/contact", name="contact")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction2(Request $request)
    {
        return $this->render('default/contact.html.twig');
    }

    /**
     * Index action
     *
     * @Route("/liberte", name="liberte")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction3(Request $request)
    {
        return $this->render('default/liberte.html.twig');
    }

    /**
     * Index action
     *
     * @Route("/plan", name="plan")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction4(Request $request)
    {
        return $this->render('default/plan.html.twig');
    }
}
