<?php

namespace App\Controller;

use App\Repository\AnnouncementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class XboxController extends AbstractController
{
    #[Route('/xbox', name: 'app_xbox')]
    public function index(AnnouncementRepository $announcementRepository): Response
    {
        $announcements = $announcementRepository->findByXbox();

        return $this->render('xbox/index.html.twig', [
            'announcements' => $announcements,
        ]);
    }
}
