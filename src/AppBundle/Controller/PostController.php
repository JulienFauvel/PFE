<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\Subject;
use AppBundle\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller
{
    /**
     * New action
     *
     * @Route("/forum/subject/{subject_id}/post/new", name="post_new", requirements={"id": "\d+"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(PostType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            /** @var Post $post */
            $post = $form->getData();

            if($post->getContent() === null || $post->getContent() === '') {
                return $this->redirectToRoute('subject_show', [
                    'id' => $request->get('subject_id')
                ]);
            }

            /** @var Subject $subject */
            $subject = $this->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Subject')
                ->getSubject($request->get('subject_id'));
            $subject->addPost($post);

            $this->getUser()->addPost($post);

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($post);
            $em->persist($subject);
            $em->persist($this->getUser());
            $em->flush();

            return $this->redirectToRoute('subject_show', [
               'id' => $post->getSubject()->getId()
            ]);
        }

        return $this->redirectToRoute('subject_show', [
            'id' => $request->get('subject_id')
        ]);
    }
}