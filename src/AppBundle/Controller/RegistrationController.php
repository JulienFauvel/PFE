<?php

namespace AppBundle\Controller;

use AppBundle\Form\RegistrationType;

use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Request;
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
        $form = $this->createForm(RegistrationType::class, null, array(
            'action' => $this->generateUrl('register_new'),
            'method' => 'POST'
        ));
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
        $form = $this->createForm(RegistrationType::class, null, array(
            'action' => $this->generateUrl('register_new'),
            'method' => 'POST'
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            //Test si l'adresse mail est déjà utilisée
            $exist = $this->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:User')
                ->getUserByEmail($user->getEmail());

            if($exist !== null) {
                $request->getSession()
                    ->getFlashBag()
                    ->add('error', 'Un compte existe déjà avec l\'adresse mail '.$user->getEmail());

                return $this->redirectToRoute('homepage');
            }

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
