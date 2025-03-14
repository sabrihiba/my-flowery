<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Create a new Product entity
        $product = new Product();

        // Create the form
        $form = $this->createForm(ProductFormType::class, $product);

        // Handle form submission
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Save the product to the database
            $entityManager->persist($product);
            $entityManager->flush();

            // Redirect or display a success message
            return $this->redirectToRoute('dashboard');
        }

        // Render the dashboard with the form
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'form' => $form->createView(),
        ]);
    }
}
