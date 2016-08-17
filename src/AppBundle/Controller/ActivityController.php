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

        return $this->render('activity/activity_detail.html.twig',
            array('activity' => $activity));
    }

}
