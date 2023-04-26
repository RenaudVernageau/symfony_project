<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartContentsController extends AbstractController
{
    #[Route('/cart/contents', name: 'app_cart_contents')]
    public function index(): Response
    {
        //Afficher les achats de l'utilisateur
        $user = $this->getUser();
        $cart = $user->getCart();
        $cartItems = $cart->getCartItems();

        return $this->render('cart_contents/index.html.twig', [
            'cartItems' => $cartItems,
        ]);
    }
}
