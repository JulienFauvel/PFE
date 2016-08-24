<?php

namespace AppBundle\Controller;

use AppBundle\Form\ActivityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
     * @Security("has_role('ROLE_USER')")
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

            $description = $activity->getDescription();
            $description = $this->removeScript($description);
            $activity->setDescription($description);

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
     * Edit action
     *
     * @Route("/activity/edit/{id}", name="activity_edit", requirements={"id": "\d+"})
     * @Security("has_role('ROLE_USER')")
     * @param integer $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction($id)
    {
        $request = $this->get('request_stack')->getCurrentRequest();

        if($id === null) {
            return $this->redirectToRoute('activity_new');
        }

        $activity = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Activity')
            ->getActivity($id);

        //Test si l'utilisateur est bien le créateur de l'activité
        if($activity->getUser()->getId() !== $this->getUser()->getId()) {
            $this->get('session')
                ->getFlashBag()
                ->add('error', 'Vous n\'avez pas créé cette activité');

            return $this->redirectToRoute('my_activities');
        }

        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var $activity */

            $activity = $form->getData();
            $description = $activity->getDescription();
            $description = $this->removeScript($description);
            $activity->setDescription($description);


            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($activity);
            $em->flush();

            $this->get('session')
                ->getFlashBag()
                ->add('success', 'Edition réussie !');

            return $this->redirectToRoute('activity_show', ['id' => $activity->getId()]);
        }

        return $this->render('activity/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }


    /**
     * Show action
     *
     * @Route("/activity/{id}", name="activity_show", requirements={"id": "\d+"})
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id = 0)
    {
        //On récupère l'activité
        $activity = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Activity')
            ->getActivity($id);

        //Si l'activité n'existe pas, on redirige vers un 404
        if($activity === null) {
            throw $this->createNotFoundException("The activity doesn't exist");
        }

        //On affiche la vue avec l'activé passé en paramètre
        return $this->render('activity/show.html.twig', [
            'activity' => $activity,
        ]);
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
            return $this->redirectToRoute('activity_new', ['c' => 'bon_plan']);
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


    /**
     * Removes script tag from html
     *
     * @param $html
     * @return string
     */
    private function removeScript($html)
    {
        $dom = new \DOMDocument();
        $dom->loadHTML(utf8_decode($html));
        $script = $dom->getElementsByTagName('script');
        $remove = [];
        foreach ($script as $item)
        {
            $remove[] = $item;
        }

        foreach ($remove as $item)
        {
            $item->parentNode->removeChild($item);
        }

        $description = preg_replace(
            array("/^\<\!DOCTYPE.*?<html><body><p>/si", "!</p></body></html>$!si"),
            "",
            $dom->saveHTML());

        return utf8_encode($description);
    }



}
