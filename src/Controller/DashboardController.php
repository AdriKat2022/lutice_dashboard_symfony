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
                'json_courses' => $json_courses,
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

    // public function exportUsers() {

    //     $users = $this->em->getRepository(User::class)->getUsers();
        
    //     $encoders = [new CsvEncoder()];
    //     $normalizers = [new ObjectNormalizer()];
    //     $serializer = new Serializer($normalizers, $encoders);
    //     $csvContent = $serializer->serialize($users, 'csv', ['csv_delimiter'=>';']);
        
    //     $response = new Response($csvContent);
    //     $response->headers->set('Content-Encoding', 'UTF-8');
    //     $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
    //     $response->headers->set('Content-Disposition', 'attachment; filename=users.csv');
        
    //     return $response;
    // }

    // #[Route('/admin/export', name : 'export_presences', methods: ['POST'], options: ['expose' => true])]

    // public function userExport(CsrfTokenManagerInterface $csrfTokenManager, Request $request) : Response
    // {

    // $user = $this->getUser();
    // $token = new CsrfToken('export_presences', $request->request->get('token'));

    // if (!$csrfTokenManager->isTokenValid($token) || !$user) {
    // return $this->json ([
    // 'code' => 403,
    // 'message' => 'Unauthorized'
    // ], 403);
    // //throw new InvalidCsrfTokenException('Le Token n\'est pas valide.');
    // }


    // $typeExport = $request->request->get('typeexport');

    // $filter = $request->request->get('filter');

    // if(empty($filter)){
    // switch ($typeExport) {
    // case 'eleves':
    // $filter = $this->em->getRepository(Eleve::class)->findAll();
    // break;
    // case 'teachers':
    // $filter = $this->em->getRepository(Teacher::class)->findAll();
    // break;
    // case 'groupes':
    // $filter = $this->em->getRepository(Groupe::class)->findAll();
    // break;
    // }

    // }

    // $dateStart = date_create($request->request->get('start'))->setTime(00, 00, 00);
    // $dateEnd = date_create($request->request->get('end'))->setTime(23, 59, 59);

    // $encoders = [new CsvEncoder()];
    // $normalizers = [new DateTimeNormalizer(['datetime_format'=>'d/m/Y H:i:s','datetime_timezone'=>'Europe/Paris']), new ObjectNormalizer()];
    // $serializer = new Serializer($normalizers, $encoders);
    // $csvContent = implode(';',[
    // 'du ',
    // $dateStart->format('d-m-Y'),
    // 'au',
    // $dateEnd->format('d-m-Y'),
    // ]).chr(10);

    // switch ($typeExport) {
    // case 'eleves':
    // $presences = $this->em->getRepository(Cours::class)->getPresencesEleves($filter, $dateStart, $dateEnd);
    // break;
    // case 'teachers':
    // $presences = $this->em->getRepository(Event::class)->getPresencesTeachers($filter, $dateStart, $dateEnd );
    // break;
    // case 'groupes':
    // $presences = $this->em->getRepository(Groupe::class)->getPresencesGroupes($filter, $dateStart, $dateEnd );
    // break;
    // }

    // $csvContent .= $serializer->serialize($presences, 'csv', [
    // 'csv_delimiter'=>';',
    // 'circular_reference_handler' => function ($object) {
    // return $object->getId();
    // }
    // ]);

    // $response = new Response($csvContent);
    // $response->headers->set('Content-Encoding', 'UTF-8');
    // $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
    // $response->headers->set('Content-Disposition', 'attachment; filename=presences-'.$dateStart->format('d-m-Y').'_'.$dateEnd->format('d-m-Y').'.csv');

    // return $response;
    // }
}
