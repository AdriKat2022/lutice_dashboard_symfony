<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Meeting;
use App\Entity\Cours;
use App\Entity\EventTeacher;

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

        // Get all the EventTeachers entities associated with the meeting (secondary teachers but soon will hold all teachers)
        $all_secondary_teachers = $entityManager
            ->getRepository(EventTeacher::class)
            ->findBy([ 'event' => $meeting->getEvent() ]);

        // Find all the associated courses for the meeting
        $all_courses = $entityManager
            ->getRepository(Cours::class)
            ->findBy([ 'event' => $meeting->getEvent() ]);

        $json_courses = array_map(function($course) {
                return [
            'id' => $course->getId(),
                    'onlineTime' => $course->getOnlineTime(),
                    'talkTime' => $course->getTalkTime(),
                    'webcamTime' => $course->getWebcamTime(),
                    'messageCount' => $course->getMessageCount(),
                    'emojis' => $course->getEmojis(),
                ];
            }, $all_courses);

        return $this->render("dashboard/show.html.twig",
            [
                'meeting' => $meeting,
                'all_secondary_teachers' => $all_secondary_teachers,
                'all_courses' => $all_courses,
                'json_courses' => $json_courses,
                'emojis_visual_map' => [
                    'raiseHand' => 'bi bi-person-raised-hand',
                    'happy' => 'bi bi-emoji-smile',
                    'neutral' => 'bi bi-emoji-neutral',
                    'frown' => 'bi bi-emoji-frown',
                    'thumbsUp' => 'bi bi-hand-thumbs-up',
                    'thumbsDown' => 'bi bi-hand-thumbs-down',
                    'clap' => 'bi bi-hand-clap',
                ],
            ]);
    }


    #[Route('/dashboard/{meeting_id}/download-csv', name: 'app_dashboard_download_csv')]
    public function download(EntityManagerInterface $entityManager, $meeting_id): Response
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
        
        $csv_headers = "First Name, Last Name, First Entered, Last Left, Online Time, Talk Time, Webcam Time, Message Count, Emojis\n";

        // Add the teacher's data to the CSV (which corresponds to the meeting properties)
        $csv_data = $meeting->getEvent()->getTeacher()->getFirstName() . "," .
                    $meeting->getEvent()->getTeacher()->getLastName() . "," .
                    $meeting->getStartTime()->format('Y-m-d H:i:s') . "," .
                    $meeting->getEndTime()->format('Y-m-d H:i:s') . "," .
                    $meeting->getOnlineTime() . "," .
                    $meeting->getTalkTime() . "," .
                    $meeting->getWebcamTime() . "," .
                    $meeting->getMessageCount() . "," .
                    $this->formatEmojisToText($meeting->getEmojis()) . "\n";
        
        // Add the courses' data to the CSV
        foreach ($all_courses as $course) {
            $csv_data .= $course->getEleve()->getFirstName() . "," .
                        $course->getEleve()->getLastName() . "," .
                        $course->getStartTime()->format('Y-m-d H:i:s') . "," .
                        $course->getEndTime()->format('Y-m-d H:i:s') . "," .
                        $course->getOnlineTime() . "," .
                        $course->getTalkTime() . "," .
                        $course->getWebcamTime() . "," .
                        $course->getMessageCount() . "," .
                        $this->formatEmojisToText($course->getEmojis() ). "\n";
        }


        $csv_content = $csv_headers . $csv_data;

        // Return the CSV file as a response
        return new Response(
            $csv_content,
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="'. $meeting->getMeetingName() .'.csv"',
            ]
        );
    }

    public function formatEmojisToText(?array $emojis): string
    {
        if (!$emojis) {
            return "";
        }
        
        $emojis_text = "";
        foreach ($emojis as $emoji_name => $emoji) {
            $emojis_text .= $emoji_name . ":" . $emoji['count'] . " ";
        }
        $emojis_text = rtrim($emojis_text, " ");

        return $emojis_text;
    }
}
