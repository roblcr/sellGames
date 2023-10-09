<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Form\AnnouncementType;
use App\Service\GameApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnouncementController extends AbstractController
{
    #[Route('/create-announcement', name: 'app_create_announcement')]
    public function createAnnouncement(Request $request, EntityManagerInterface $em, GameApiService $gameApiService)
    {
        $announcement = new Announcement();
        $form = $this->createForm(AnnouncementType::class, $announcement);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('images')->getData();

            if ($imageFile instanceof UploadedFile) {
                // Gérez le téléchargement et l'enregistrement de l'image ici
                $newFileName = md5(uniqid()) . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFileName
                );

                // Enregistrez le nom du fichier d'image dans l'entité Announcement
                $announcement->setImages([$newFileName]);
            }

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
