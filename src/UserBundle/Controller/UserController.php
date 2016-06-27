<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use UserBundle\Form\UserType;
use UserBundle\Entity\User;

/**
 * Class UserController
 * @package UserBundle\Controller
 */
class UserController extends Controller
{

    /**
     * @Route("/user/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'UserBundle:User:login.html.twig',
            [
                'last_username' => $lastUsername,
                'error' => $error,
            ]
        );
    }


    /**
     * @Route("/user/register", name="user_registration")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registrationAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setIsActive(false);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('replace_with_some_route');
        }

        return $this->render(
            'UserBundle:User:registration.html.twig',
            ['form' => $form->createView()]
        );
    }

}