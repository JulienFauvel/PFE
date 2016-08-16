<?php


namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class ProfileController
 * @package AppBundle\Controller
 */
class ProfileController extends Controller
{

    /**
     * Index action
     *
     * @Route("/profile", name="profile")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('profile/index.html.twig');
    }

}