<?php


namespace AppBundle\Controller;

use AppBundle\Form\EditUserType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class ProfileController
 * @package AppBundle\Controller
 */
class ProfileController extends Controller
{

    /**
     * Index action
     *
     * @Route("/profile", name="profile")
     * @Security("has_role('ROLE_USER')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('profile/index.html.twig');
    }

    /**
     * Show action
     * @Route("/profile/{id}", name="profile_show", requirements={"id": "\d+"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $user = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:User')
            ->getUser($id);

        return $this->render('profile/show.html.twig', [
           'user' => $user
        ]);
    }

    /**
     * Edit action
     *
     * @Route("/profile/edit", name="profile_edit")
     * @Security("has_role('ROLE_USER')")
     * @param $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request)
    {
        $user = $this->getUser();
        $entity = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:User')
            ->getUser($user->getId());

        if($entity === null)
        {
            throw $this->createNotFoundException('Unable to find user ' . $user->getId());
        }

        $form = $this->createForm(EditUserType::class, $entity);
        $form->handleRequest($request);

        if ($request->getMethod() === 'POST'
            && $form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            if($this->getUser()->getEmail() !== $user->getEmail()) {
                //Test si l'adresse mail est déjà utilisée
                $exist = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('AppBundle:User')
                    ->getUserByEmail($user->getEmail());

                if ($exist !== null) {
                    $request->getSession()
                        ->getFlashBag()
                        ->add('error', 'Un compte existe déjà avec l\'adresse mail ' . $user->getEmail());

                    return $this->redirectToRoute('profile');
                }
            }
            /** @var UploadedFile $image */
            $image = $user->getProfilePictureFile();

            if($image !== null) {
                $fileName = md5(uniqid()).'.'.$image->guessExtension();

                $image->move(
                    $this->getParameter('profile_image_directory'),
                    $fileName
                );

                $user->setProfilePicturePath($fileName);
            }

            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($user);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Edition réussite !');

            return $this->redirectToRoute('profile');
        } else {
            $this->getDoctrine()->getEntityManager()->refresh($user);
        }

        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }



    /**
     * My activities Action
     *
     * @Route("/profile/activities", name="my_activities")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function myActivitiesAction(Request $request)
    {
        $activities = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Activity')
            ->getActivitiesByUser($this->getUser()->getId());

        return $this->render('profile/myactivities.html.twig', [
           'activities' => $activities
        ]);
    }

    /**
     * My subjects Action
     *
     * @Route("/profile/subjects", name="my_subjects")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mySubjectsAction(Request $request)
    {
        $subjects = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Subject')
            ->getSubjectsByUser($this->getUser()->getId());

        return $this->render('profile/mysubjects.html.twig', [
           'subjects' => $subjects
        ]);
    }
}