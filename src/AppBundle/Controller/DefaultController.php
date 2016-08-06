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
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig');
    }

}
