<?php
/**
 * Created by PhpStorm.
 * User: Moh-K
 * Date: 16/08/2016
 * Time: 19:45
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ForumController
 * @package AppBundle\Controller
 */
class BonplansController extends Controller
{

    /**
     * Index action
     *
     * @Route("/bonplans", name="bonplans")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $bonplans = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Activity')
            ->getBonplans();

        return $this->render('bonplans/bonplans.html.twig',
            array('bonplans' => $bonplans));
    }

}