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
     * @Route("/admin/user/disable/{id}", name="user_disable", requirements={"id": "\d+"})
     * @param integer $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function userDisableAction($id)
    {
        return $this->redirectToRoute('admin');
    }

    /**
     * Admin contact
     *
     * @Route("/admin/contacts", name="admin_contact")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactAction(Request $request)
    {
        $contacts = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Contact')
            ->getContacts();

        return $this->render('admin/contact.html.twig', [
            'contacts' => $contacts
        ]);
    }

}