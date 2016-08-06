<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\RegistrationType;
use AppBundle\Form\UserType;

use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class RegistrationController
 * @package AppBundle\Controller
 */
class RegistrationController extends BaseController
{

    /**
     * Register index action
     *
     * @Route("/register", name="register")
     *
     * @param $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(RegistrationType::class);
        $form->handleRequest($request);

        return $this->render('register/register.html.twig',
            array(
                'form' => $form->createView(),
            ));
    }

    /**
     * Register new action
     *
     * @Route("/register/new", name="register_new")
     *
     * @param $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(RegistrationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($user);
            $em->flush();


            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Inscription réussite !');

            return $this->redirectToRoute('profile');
        }

        return $this->render('register/register.html.twig',
            array(
                'form' => $form->createView(),
            ));
    }

}
