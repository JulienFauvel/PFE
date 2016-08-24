<?php


namespace AppBundle\Controller;


use AppBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class StaticController extends Controller
{
    /**
     * Index action
     *
     * @Route("/confidentialite", name="confidentialite")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexConfidentialiteAction(Request $request)
    {
        return $this->render('default/confidentialite.html.twig');
    }

    /**
     * Index action
     *
     * @Route("/contact", name="contact")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexContactAction(Request $request)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $this->getUser()->addContact($contact);

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($contact);
            $em->persist($this->getUser());
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Message envoyé !');

            return $this->redirectToRoute('contact');
        }

        return $this->render('default/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * Index action
     *
     * @Route("/liberte", name="liberte")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexLiberteAction(Request $request)
    {
        return $this->render('default/liberte.html.twig');
    }

    /**
     * Index action
     *
     * @Route("/plan", name="plan")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexPlanAction(Request $request)
    {
        return $this->render('default/plan.html.twig');
    }
}
