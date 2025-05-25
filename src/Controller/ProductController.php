<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/admin/product/new', name: 'product_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Set the current date/time for createdP
            $product->setCreatedP(new \DateTime());

            // Save the product to the database
            $em->persist($product);
            $em->flush();

            // Redirect to the shop page
            return $this->redirectToRoute('shop');
        }

        return $this->render('product/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
