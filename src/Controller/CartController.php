<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Entity\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(): Response
    {
        $user = $this->getUser();

        if ($user) {

            $cart = $user->getCart();

            $announcements = $cart ? $cart->getAnnouncements() : [];

            return $this->render('cart/index.html.twig', [
                'announcements' => $announcements,
            ]);
        }

        return $this->redirectToRoute('app_login');
    }


    #[Route('/cart/add/{announcement}', name: 'cart_add')]
    public function addToCart(Announcement $announcement, Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $cart = $user->getCart();

        if ($cart === null) {
            $cart = new Cart();
            $user->setCart($cart);
        }

        $cart->addAnnouncement($announcement);

        $em->persist($user);
        $em->flush();

        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

    #[Route('/cart/remove/{announcement}', name: 'cart_remove')]
    public function removeFromCart(Announcement $announcement): Response
    {
        $user = $this->getUser();

        $cart = $user->getCart();

        $cart->removeAnnouncement($announcement);

        return $this->redirectToRoute('app_cart');
    }
}
