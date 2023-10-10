<?php

namespace App\Controller;

use App\Config\Category;
use App\Config\Platform;
use App\Entity\Announcement;
use App\Form\AnnouncementType;
use App\Repository\AnnouncementRepository;
use App\Service\GameApiService;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Stmt\Catch_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnouncementController extends AbstractController
{

    #[Route('/announcements', name: 'app_announcements')]
    public function index(AnnouncementRepository $announcementRepository, Request $request)
    {
        $announcements = $announcementRepository->findAll();

        $categories = [
            Category::Action,
            Category::Aventure,
            Category::BattleRoyal,
            Category::Combat,
            Category::FPS,
            Category::Horror,
            Category::MMORPG,
            Category::MOBA,
            Category::PartyGame,
            Category::Platform,
            Category::Puzzle,
            Category::Reflexion,
            Category::RogueLike,
            Category::RPG,
            Category::RTS,
            Category::Sandbox,
            Category::Simulation,
            Category::Survival,
            Category::TPS
        ];

        $platforms = [
            Platform::Nintendo,
            Platform::PC,
            Platform::Playstation,
            Platform::Xbox
        ];

        return $this->render('announcement/index.html.twig', [
            'announcements' => $announcements,
            'platforms' => $platforms,
            'categories' => $categories
        ]);
    }

    #[Route('/announcement/{id}', name: 'app_announcement_details')]
    public function showAnnouncement(int $id, AnnouncementRepository $announcementRepository)
    {
        $announcement = $announcementRepository->find($id);

        if (!$announcement) {
            throw $this->createNotFoundException('Annonce non trouvée');
        }

        return $this->render('announcement/details.html.twig', [
            'announcement' => $announcement,
        ]);
    }

    #[Route('/create-announcement', name: 'app_create_announcement')]
    public function createAnnouncement(Request $request, EntityManagerInterface $em)
    {
        $announcement = new Announcement();
        $form = $this->createForm(AnnouncementType::class, $announcement);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $images = $form->get('images')->getData();
            $uploadedImages = [];

            foreach ($images as $image) {
                /** @var UploadedFile $image */
                dump($image[0]);
                $fileName = md5(uniqid()) . '.' . $image[0]->guessExtension();
                $image[0]->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
                $uploadedImages[] = $fileName;
            }

            $announcement->setImages($uploadedImages);

            $announcement->setPublishedDate(new \DateTime());
            // Enregistrer l'annonce dans la base de données
            $em->persist($announcement);
            $em->flush();

            // Rediriger vers une page de confirmation ou ailleurs
            return $this->redirectToRoute('app_home');
        }

        return $this->render('announcement/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/search-games', name: 'app_search_games')]
    public function searchGames(Request $request, GameApiService $gameApiService)
    {
        $searchTerm = $request->query->get('q');

        if ($searchTerm !== null) {
            // Utilisez le service GameApiService pour effectuer la recherche.
            $results = $gameApiService->searchGames($searchTerm);

            // Renvoyez les résultats au format JSON.
            return new JsonResponse($results);
        }

        return new JsonResponse([]);
    }
}
