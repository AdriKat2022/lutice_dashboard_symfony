<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Meeting;
use App\Entity\Cours;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard_index')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'This page hasn\'t been implemented yet.',
            'path' => 'src/Controller/DashboardController.php',
        ]);
    }

    #[Route('/dashboard/{meeting_id}', name: 'app_dashboard_show')]
    public function show(EntityManagerInterface $entityManager, $meeting_id): Response
    {
        // Get the meeting with the given ID (corresponds to the meeting_id in the database)
        $meeting = $entityManager
            ->getRepository(Meeting::class)
            ->findOneBy([ 'meetingId' => $meeting_id ]);

        // If the meeting doesn't exist, return a 404 error
        if (!$meeting) {
            return $this->render("dashboard/not_found.html.twig",
                [
                    'meeting_id' => $meeting_id,
                ]
        );
        }
        
        // If the dashboard isn't ready (dashboardReady property)
        if (!$meeting->isDashboardReady()) {
            return $this->render("dashboard/not_ready.html.twig",
                [
                    'meeting' => $meeting,
                ]);
        }

        // Find all the associated courses for the meeting
        $all_courses = $entityManager
            ->getRepository(Cours::class)
            ->findBy([ 'event' => $meeting->getEvent() ]);

        // $all_emojis = [];
        // foreach ($all_courses as $course) {
        //     $all_emojis[$course->getId()] = $course->getEmojis();
        // }

        return $this->render("dashboard/show.html.twig",
            [
                'meeting' => $meeting,
                'all_courses' => $all_courses,
                'emojis_visual_map' => [
                    'raiseHand' => 'bi bi-person-raised-hand',
                    'happy' => 'bi bi-emoji-smile',
                    'smile' => 'bi bi-emoji-smile',
                    'frown' => 'bi bi-emoji-frown',
                    'neutral' => 'bi bi-emoji-neutral',
                ],
            ]);
    }
}
