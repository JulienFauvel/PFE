<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class AdminController
 * @package AppBundle\Controller
 */
class AdminController extends Controller
{

    /**
     * Index action
     *
     * @Route("/admin", name="admin")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $users = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->getUsers();

        return $this->render('admin/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * User DELETE action
     *
     * @Route("/admin/user/delete/{id}", name="user_delete", requirements={"id": "\d+"})
     * @param integer $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function userDeleteAction($id)
    {
        return $this->redirectToRoute('admin');
    }

}