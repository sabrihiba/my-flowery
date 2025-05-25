<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
public function profile(): Response
{
    $user = $this->getUser(); // Get logged-in user
    return $this->render('profile/index.html.twig', [
        'user' => $user,
    ]);
}
#[Route('/profile/edit', name: 'app_edit_profile')]
public function edit(Request $request, EntityManagerInterface $em): Response
{
    $user = $this->getUser();

    $form = $this->createForm(EditProfileType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();

        $this->addFlash('success', 'Profile updated!');
        return $this->redirectToRoute('app_profile');
    }

    return $this->render('profile/edit.html.twig', [
        'form' => $form->createView(),
    ]);
}
#[Route('/profile/change-password', name: 'app_change_password')]
public function changePassword(Request $request, UserPasswordHasherInterface $passwordHasher): Response
{
    $user = $this->getUser();
    $form = $this->createForm(ChangePasswordType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $oldPassword = $form->get('oldPassword')->getData();
        $newPassword = $form->get('newPassword')->getData();
        $confirmPassword = $form->get('confirmPassword')->getData();

        // Check if old password is correct
        if (!$passwordHasher->isPasswordValid($user, $oldPassword)) {
            $this->addFlash('error', 'Current password is incorrect.');
        } elseif ($newPassword !== $confirmPassword) {
            $this->addFlash('error', 'New password and confirmation do not match.');
        } else {
            // Hash and set new password
            $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
            $user->setPassword($hashedPassword);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Password changed successfully.');

            return $this->redirectToRoute('app_profile');
        }
    }

    return $this->render('profile/change_password.html.twig', [
        'changePasswordForm' => $form->createView(),
    ]);
}
}
