<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     * @Route("/user/{id}", name="user_details")
     */
    public function details(User $user = null): Response
    {
        $user = $user ?? $this->getUser();
        if (! $user) {
            return $this->redirectToRoute('login');
        }
        return $this->render('user/details.html.twig', [
            'user' => $user
        ]);
    }


    /**
     * @Route("/user/{id}/edit", name="edit_user")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * 
     */
    public function userForm(Request $request, EntityManagerInterface $manager): Response 
    {
        $user = $this->getUser();

        $userForm = $this->createForm(UserType::class, $user);

        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            // enregistrement du jeu en base de données
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('profile');
        }

        return $this->render('user/user-form.html.twig', [
            'user_form' => $userForm->createView()
        ]);
    }
}
