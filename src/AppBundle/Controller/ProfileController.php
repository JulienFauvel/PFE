<?php


namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
        //$securityContext = $this->get('security.authorization_checker');
        //if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
        //    return $this->redirectToRoute('fos_user_security_login');
        //}

        return $this->render(
            'profile/index.html.twig'
        );
    }

}