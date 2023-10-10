<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Repository\AnnouncementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(AnnouncementRepository $announcementRepository): Response
    {
        $announcements = $announcementRepository->findAll();

        $randomAnnouncements = $announcementRepository->getRandomAnnouncements();

        return $this->render('home/index.html.twig', [
            'announcements' => $announcements,
            'randomAnnouncements' => $randomAnnouncements
        ]);
    }
}
