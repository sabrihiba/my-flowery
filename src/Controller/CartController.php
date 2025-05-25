<?php
namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class CartController extends AbstractController
{
    // Show the cart page
    #[Route('/cart', name: 'cart')]
    public function index(SessionInterface $session)
    {
        $cart = $session->get('cart', []);  // Get the cart from session, or empty array if not set

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
        ]);
    }

    // Handle adding product to the cart
    #[Route('/cart/add/{id}', name: 'add_to_cart', methods: ['POST'])]
    public function addToCart(int $id, Request $request, SessionInterface $session, EntityManagerInterface $entityManager)
    {
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        // Get form values
        $quantity = (int) $request->request->get('quantity', 1);

        // Get the cart from session
        $cart = $session->get('cart', []);

        // Create an associative array for the product
        $cartItem = [
            'id' => $product->getId(),
            'name' => $product->getNameP(),
            'price' => $product->getPriceP(),
            'quantity' => $quantity,
            'totalPrice' => $product->getPriceP() * $quantity,
        ];

        // Store the updated cart
        $cart[] = $cartItem;
        $session->set('cart', $cart);

        // Redirect to the cart page
        return $this->redirectToRoute('cart');
    }
}
