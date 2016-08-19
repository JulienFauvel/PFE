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
     * New action
     *
     * @Route("/activity/new", name="activity_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $categories = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Category')
            ->getCategories();

        return $this->render('activity/new.html.twig',
            [
                'default_cat' => $request->get('c'),
                'categories' => $categories
            ]
        );
    }


    /**
     * Show action
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

        return $this->render('activity/show.html.twig',
            ['activity' => $activity]);
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

        $cat = null;
        if(count($activities) > 0) $cat = $activities[0]->getCategory();

        if($cat === null)
        {
            return $this->redirectToRoute('activity_new', ['c' => 'restaurant']);
        }

        return $this->render('activity/index.html.twig',
            [
                'activities' => $activities,
                'category' => $cat
            ]
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

        $cat = null;
        if(count($activities) > 0) $cat = $activities[0]->getCategory();

        if($cat === null)
        {
            return $this->redirectToRoute('activity_new', ['c' => 'bonplan']);
        }

        return $this->render('activity/index.html.twig',
            [
                'activities' => $activities,
                'category' => $cat
            ]
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

        $cat = null;
        if(count($activities) > 0) $cat = $activities[0]->getCategory();

        if($cat === null)
        {
            return $this->redirectToRoute('activity_new', ['c' => 'voyage']);
        }
        return $this->render('activity/index.html.twig',
            [
                'activities' => $activities,
                'category' => $cat
            ]
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

        $cat = null;
        if(count($activities) > 0) $cat = $activities[0]->getCategory();

        if($cat === null)
        {
            return $this->redirectToRoute('activity_new', ['c' => 'bar_loisir']);
        }

        return $this->render('activity/index.html.twig',
            [
                'activities' => $activities,
                'category' => $cat
            ]
        );
    }



}
