<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Post;
use AppBundle\Entity\Subject;
use AppBundle\Form\PostType;
use AppBundle\Form\SubjectPostType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class SubjectController extends Controller
{

    /**
     * New action
     *
     * @Route("/forum/subject/new", name="subject_new")
     * @Security("has_role('ROLE_USER')")
     * @param $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(SubjectPostType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $obj = $form->getData();

            $post = new Post();
            $post->setContent($obj['post']);

            $subject = new Subject();
            $subject->setName($obj['subject']);
            $subject->addPost($post);

            $this->getUser()->addSubject($subject);
            $this->getUser()->addPost($post);

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($post);
            $em->persist($subject);
            $em->persist($this->getUser());
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Création réussie !');

            return $this->redirectToRoute('my_subjects');
        }

        return $this->render('subject/new.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * Show action
     *
     * @Route("/forum/subject/show/{id}", name="subject_show", requirements={"id": "\d+"})
     * @param integer $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $request = $this->get('request_stack')->getCurrentRequest();

        /** @var Subject $subject */
        $subject = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Subject')
            ->getSubject($id);

        $post = new Post();
        $post->setSubject($subject);

        $form = $this->createForm(PostType::class, $post, [
            'action' => $this->generateUrl('post_new', [
                'subject_id' => $subject->getId()
            ])
        ]);
        $form->handleRequest($request);

        return $this->render('subject/show.html.twig', [
            'subject' => $subject,
            'form' => $form->createView()
        ]);
    }

}