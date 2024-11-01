<?php

namespace App\Controller;

use App\Entity\Roles;
use App\Entity\Users;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request,
                             UserPasswordHasherInterface $userPasswordHasher,
                             Security $security,
                             EntityManagerInterface $entityManager): Response
    {
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            // Attribuer les rôles
            $rolePassager = new Roles();
            $rolePassager->setLibelle('ROLE_PASSAGER');

            $roleChauffeur = new Roles();
            $roleChauffeur->setLibelle('ROLE_CHAUFFEUR');

            // Assigner le rôle en fonction de isDriver
            $user->addRole($rolePassager); // Par défaut, tout utilisateur est passager
            $entityManager->persist($rolePassager);
            if ($user->isDriver()) {
                $user->addRole($roleChauffeur);
                $entityManager->persist($roleChauffeur);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            // Connecter l'utilisateur
            $security->login($user);

            // Rediriger l'utilisateur en fonction de son rôle
            if ($user->isDriver()) {
                return $this->redirectToRoute('app_driver_space');
            } else {
                return $this->redirectToRoute('app_passenger_space');
            }



//           return $security->login($user, 'form_login', 'main');

//
        }



        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
