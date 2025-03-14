<?php
namespace App\Controller;

use App\Entity\Product;  // Ensure you have the Product entity
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
        $cart = $session->get('cart', []);  // Get the cart from session, or an empty array if not set

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
    $extraFlowers = (int) $request->request->get('extraFlowers', 0);
    $letterText = $request->request->get('letterText', null);
    $chocolatesQuantity = (int) $request->request->get('chocolatesQuantity', 0);

    // Get the cart from session
    $cart = $session->get('cart', []);

    // Create an associative array for the product
    $cartItem = [
        'id' => $product->getId(),
        'name' => $product->getNameP(),
        'price' => $product->getPriceP(),
        'quantity' => $quantity,
        'extraFlowers' => $extraFlowers,
        'letterText' => $letterText,
        'chocolatesQuantity' => $chocolatesQuantity,
        'totalPrice' => $this->calculateTotalPrice($product, $quantity, $extraFlowers, $chocolatesQuantity),
    ];

    // Store the updated cart
    $cart[] = $cartItem;
    $session->set('cart', $cart);

    // Redirect to the cart page
    return $this->redirectToRoute('cart');
}
private function calculateTotalPrice(Product $product, int $quantity, int $extraFlowers, ?int $chocolatesQuantity): float
{
    $price = $product->getPriceP(); 
    $extraFlowersCost = $extraFlowers * 5; // $5 per extra flower
    $chocolatesCost = $chocolatesQuantity ? $chocolatesQuantity * 30 : 0; // $30 per chocolate box

    return ($price + $extraFlowersCost + $chocolatesCost) * $quantity;
}

}