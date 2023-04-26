<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartContents;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(): Response
    {
        //Afficher les achats de l'utilisateur
        $user = $this->getUser();
        $cart = $user->getCart();

        if (!$cart) {
            // Si le panier n'existe pas encore, vous pouvez créer un nouveau panier ici
            $cart = new Cart();
            $cart->setUser($user);
            $cart->setStatus(0);
            $cart->setDate(new \DateTime());
        }

        $cartContents = $cart->getCartContents();

        return $this->render('cart/index.html.twig', [
            'cartContents' => $cartContents,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function addProduct(Product $product, EntityManagerInterface $em): Response
    {
        // Ajouter un produit dans le panier de l'utilisateur
        $user = $this->getUser();

        // $cart = $user->getCarts();
        $cart = $em->getRepository(Cart::class)->findOneBy(['user' => $user, 'status' => 0]);

        if (!$cart) {
            $cart = new Cart();
            $cart->setUser($user);
            $cart->setStatus(0);
            $cart->setDate(new \DateTime());
        }

        $cartItem = $em->getRepository(CartItem::class)->findOneBy(['cart' => $cart, 'product' => $product]);

        if (!$cartItem) {
            $cartItem = new CartItem();
            $cartItem->setCart($cart);
            $cartItem->setProduct($product);
            $cartItem->setQuantity(1);
        } else {
            $cartItem->setQuantity($cartItem->getQuantity() + 1);
        }

        $em->persist($cart);
        $em->persist($cartItem);
        $em->flush();

        return $this->redirectToRoute('app_cart');

        $product = $this->getDoctrine()->getRepository(Product::class)->find($productId);

        if (!$product) {
            throw $this->createNotFoundException('Le produit n\'existe pas');
        }

        $cartItem = $this->getDoctrine()->getRepository(CartItem::class)->findOneBy([
            'cart' => $cart,
            'product' => $product
        ]);

        if (!$cartItem) {
            $cartItem = new CartItem();
            $cartItem->setCart($cart)
                ->setProduct($product)
                ->setQuantity(1);
        } else {
            $cartItem->setQuantity($cartItem->getQuantity() + 1);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($cartItem);
        $entityManager->flush();

        return $this->redirectToRoute('app_cart');
    }
}
