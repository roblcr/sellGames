<?php

namespace App\Controller;

use App\Repository\AnnouncementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PcController extends AbstractController
{
    #[Route('/pc', name: 'app_pc')]
    public function index(AnnouncementRepository $announcementRepository): Response
    {
        $announcements = $announcementRepository->findByPc();

        return $this->render('pc/index.html.twig', [
            'announcements' => $announcements,
        ]);
    }
}
