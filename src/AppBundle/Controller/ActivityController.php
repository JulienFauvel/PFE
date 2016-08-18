<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ActivityController
 * @package AppBundle\Controller
 */
class ActivityController extends Controller
{

    /**
     * Index action
     *
     * @Route("/activity/{id}", requirements={"id" = "\d+"}, name="activity_detail")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id = 0)
    {
        $activity = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Activity')
            ->getActivity($id);

        if($activity === null) {
            throw $this->createNotFoundException("The activity doesn't exist");
        }

        return $this->render('activity/activity_detail.html.twig',
            array('activity' => $activity));
    }

    /**
     * Restaurant index action
     *
     * @Route("/restaurants", name="restaurants")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function restaurantIndexAction(Request $request) {

        $activities = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Activity')
            ->getActivitiesByCategory('restaurant');

        return $this->render('activity/index.html.twig',
            array('activities' => $activities, 'category' => 'Restaurants')
        );
    }

    /**
     * Bon plans index action
     *
     * @Route("/bonplans", name="bonplans")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function bonPlanIndexAction(Request $request) {

        $activities = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Activity')
            ->getActivitiesByCategory('bonplan');

        return $this->render('activity/index.html.twig',
            array('activities' => $activities, 'category' => 'Bon Plans')
        );
    }

    /**
     * Voyage index action
     *
     * @Route("/voyages", name="voyages")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function voyageIndexAction(Request $request) {

        $activities = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Activity')
            ->getActivitiesByCategory('voyage');

        return $this->render('activity/index.html.twig',
            array('activities' => $activities, 'category' => 'Voyages')
        );
    }

    /**
     * Bar-loisir index action
     *
     * @Route("/bars-loisirs", name="bars-loisirs")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function barLoisirIndexAction(Request $request) {

        $activities = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Activity')
            ->getActivitiesByCategory('bar_loisir');

        return $this->render('activity/index.html.twig',
            array('activities' => $activities, 'category' => 'Bars & Loisirs')
        );
    }



}
