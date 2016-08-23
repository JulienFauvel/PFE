<?php

namespace AppBundle\Controller;

use AppBundle\Form\ActivityType;
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

        $form = $this->createForm(ActivityType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activity = $form->getData();
            $this->getUser()->addActivity($activity);

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($activity);
            $em->persist($this->getUser());
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Création réussie !');

            return $this->redirectToRoute('my_activities');
        }

        return $this->render('activity/new.html.twig',
            [
                'default_cat' => $request->get('c'),
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * New action
     *
     * @Route("/activity/edit/{id}", name="activity_edit")
     * @param integer $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction($id)
    {

        if($id === null) {
            return $this->redirectToRoute('activity_new');
        }

        $activity = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Category')
            ->getActivity($id);

        //Test si l'utilisateur est bien le créateur de l'activité
        if($activity->getUser()->getId() !== $this->getUser()->getId()) {
            $this->get('session')
                ->getFlashBag()
                ->add('error', 'Vous n\'avez pas créé cette activité');

            return $this->redirectToRoute('my_activities');
        }

        $form = $this->createForm(ActivityType::class, $activity);

        if ($form->isSubmitted() && $form->isValid()) {
            $activity = $form->getData();

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($activity);
            $em->flush();

            $this->get('session')
                ->getFlashBag()
                ->add('success', 'Edition réussie !');

            return $this->redirectToRoute('showAction', ['id' => $activity->getId()]);
        }

        return $this->render('activity/edit.html.twig',[
            'form' => $form
        ]);
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
