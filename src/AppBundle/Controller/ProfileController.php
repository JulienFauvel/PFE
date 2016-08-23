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
        /*
        if(!$this->isGranted('ROLE_USER'))
        {
            return $this->redirectToRoute('homepage');
        }
        */

        return $this->render('profile/index.html.twig');
    }

    /**
     * Show action
     * @Route("/profile/{id}", name="profile_show")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $user = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:User')
            ->getUser($id);

        return $this->render('profile/show.html.twig', [
           'user' => $user
        ]);
    }

    /**
     * My activities Action
     *
     * @Route("/profile/activities", name="my_activities")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function myActivitiesAction(Request $request)
    {
        $activities = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Activity')
            ->getActivitiesByUser($this->getUser()->getId());

        return $this->render('profile/myactivities.html.twig', [
           'activities' => $activities
        ]);
    }

    /**
     * My subjects Action
     *
     * @Route("/profile/subjects", name="my_subjects")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mySubjectsAction(Request $request)
    {
        $subjects = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Subject')
            ->getSubjectsByUser($this->getUser()->getId());

        return $this->render('profile/mysubjects.html.twig', [
           'subjects' => $subjects
        ]);
    }
}