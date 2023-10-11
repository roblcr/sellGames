<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    #[Route('/checkout', name: 'app_checkout')]
    public function index(): Response
    {
        $user = $this->getUser();
        $cart = $user->getCart();
        $announcements = $cart->getAnnouncements();

        return $this->render('checkout/index.html.twig', [
            'announcements' => $announcements,
        ]);
    }
}
