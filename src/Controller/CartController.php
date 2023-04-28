<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\CartContentsRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
	#[Route('/cart', name: 'app_cart')]
	public function index(SessionInterface $session, ProductRepository $productRepository): Response
	{
		//On récupère le panier actuel
		$cart = $session->get("cart", []);

		//On fabrique les données
		$cartWithData = [];
		$total = 0;

		//On boucle sur le panier
		foreach ($cart as $id => $quantity) {
			//On récupère le produit
			$product = $productRepository->find($id);

			// On vérifie si le produit a été trouvé
			if ($product !== null) {
				// On fabrique les données
				$cartWithData[] = [
					"product" => $product,
					"quantity" => $quantity
				];

				//On calcule le total
				$total += $product->getPrice() * $quantity;
			}
		}

		//On affiche le rendu
		return $this->render('cart/index.html.twig', [
			"items" => $cartWithData,
			"total" => $total
		]);
	}

	#[Route('/cart/add/{id}', name: 'app_cart_add')]
	public function addProduct(Product $product, SessionInterface $session): Response
	{
		//On récupère le panier actuel
		$cart = $session->get("cart", []);
		$id = $product->getId();

		//Si le panier n'est pas vide
		if (!empty($cart)) {
			//On vérifie si le produit est déjà dans le panier
			if (isset($cart[$id])) {
				//Si oui, on augmente la quantité
				$cart[$id]++;
			} else {
				//Si non, on ajoute le produit
				$cart[$id] = 1;
			}
		} else {
			//Si le panier est vide, on ajoute le produit
			$cart[$id] = 1;
		}

		//On enregistre le panier
		$session->set("cart", $cart);

		//On redirige vers le panier
		return $this->redirectToRoute("app_cart");
	}

	#[Route('/cart/remove/{id}', name: 'app_cart_remove')]
	public function remove(Product $product, SessionInterface $session)
	{
		//On récupère le panier actuel
		$cart = $session->get("cart", []);
		$id = $product->getId();

		//Si le panier n'est pas vide
		if (!empty($cart)) {
			//On vérifie si le produit est déjà dans le panier
			if (isset($cart[$id])) {
				//Si oui, on augmente la quantité
				$cart[$id]--;
			} else {
				//Si non, on ajoute le produit
				$cart[$id] = 1;
			}
		} else {
			//Si le panier est vide, on ajoute le produit
			$cart[$id] = 1;
		}

		//On enregistre le panier
		$session->set("cart", $cart);

		//On redirige vers le panier
		return $this->redirectToRoute("app_cart");
	}
}
