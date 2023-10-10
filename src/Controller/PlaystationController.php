<?php

namespace App\Controller;

use App\Repository\AnnouncementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlaystationController extends AbstractController
{
    #[Route('/playstation', name: 'app_playstation')]
    public function index(AnnouncementRepository $announcementRepository): Response
    {
        $announcements = $announcementRepository->findByPlaystation();

        return $this->render('playstation/index.html.twig', [
            'announcements' => $announcements,
        ]);
    }
}
