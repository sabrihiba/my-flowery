<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    #[Route('/shop', name: 'shop')]
    public function index(ProductRepository $productRepository): Response
    {
        // Fetch all products from the database
        $products = $productRepository->findAll();

        return $this->render('shop/index.html.twig', [
            'products' => $products,
        ]);
    }
}
