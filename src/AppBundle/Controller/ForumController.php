<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ForumController
 * @package AppBundle\Controller
 */
class ForumController extends Controller
{

    /**
     * Index action
     *
     * @Route("/forum", name="forum")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $subjects = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Subject')
            ->getSubjects();

        return $this->render('forum/forum.html.twig',
            array('subjects' => $subjects));
    }

    /**
     * Show action
     *
     * @Route("/forum/subject/show/{id}", name="subject_show", requirements={"id": "\d+"})
     * @param integer $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $subject = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Subject')
            ->getSubject($id);

        return $this->render('subject/show.html.twig',
            array('subject' => $subject));
    }

    /**
     * Index action
     *
     * @Route("/forum/regles", name="forum_regles")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexReglesAction(Request $request)
    {
        return $this->render('forum/regles.html.twig');
    }

}