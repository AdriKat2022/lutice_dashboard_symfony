<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Cours;
use App\Entity\Meeting;
use App\Entity\Eleve;

class ImportDashboards extends Command
{
    private $entityManager;
    
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:import-dashboards';
    protected static $defaultDescription = 'Import the BBB JSON dashboards into the Lutice database';

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
	parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('DashboardsDirectory', InputArgument::REQUIRED, 'The path of the dashboard JSON to import');
        $this->setHelp('This command allows you to import the BBB JSON dashboards into the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dashboard_path = $input->getArgument('DashboardsDirectory');

        $output->writeln('Importing dashboards...');

        // Find all the JSON files in the directory
        $dashboardFiles = glob($dashboard_path . '/*.json');
        $output->writeln('Found ' . count($dashboardFiles) . ' dashboards to import');

        // Import each dashboard
        foreach ($dashboardFiles as $dashboardFile) {
            $output->writeln('Importing ' . $dashboardFile . "...");
            $this->importDashboard($dashboardFile);
        }

        $output->writeln('Dashboards imported successfully!');

        return Command::SUCCESS;
    }

    protected function importDashboard($dashboard_path) : void
    {
        // Serialze the JSON file into an nested array
        $dashboard = json_decode(file_get_contents($dashboard_path), true);
	    dump(print_r($dashboard));

        // Get the meeting entity from the database
        $meeting = $this->entityManager->getRepository('App\Entity\Meeting')->findOneBy(['meetingId' => $dashboard['extId']]);

        if (!$meeting){
            dump("Failed to retrieve meeting. Skipping.");
            return;
        }	

        $event_id = $meeting->getEvent()->getId();

        // Import the JSON dashboards
        // - (intId -> meetingId)
        // - (extId -> recordId)
        // - (name -> meetingName)
        // - (polls -> ???) (do nothing for now)
        // - (screenshares -> ???) [store TIME ONLY] 
        // - (presentationSlides -> ???) [JSON] 
        // - (createdOn -> starttime) DONE
        // - (endedOn -> endtime) DONE
        $meeting->setStartTime((new \DateTime())->setTimestamp((int)($dashboard['createdOn']/1000)));
        $meeting->setEndTime((new \DateTime())->setTimestamp((int)($dashboard['endedOn']/1000)));
        $this->entityManager->persist($meeting);

        // For each user in the meeting (dashboard)
        // Info about the course (for each student)
		// - (event [DEDUCED from MEETING])
        // - (extId -> eleve)
        // - (name + eventName -> cours name ?)
        // - (intIds -> onlineTime [DEDUCED])
		// - (isModerator -> isTeacher ?) [Do nothing for now]
		// - (answers -> ?) [Do nothing for now]
        // - (talk -> talkTime)
        // - (emojis -> emojis) [en JSON]
		// - (webcams -> webcamTime) [count]
        // - (totalOfMessages -> messageCount)

        foreach ($dashboard['users'] as $key => $user_info)
		{

			$cours = $this->entityManager->getRepository('App\Entity\Cours')->findOneBy(
				[
					'event' => $event_id,
					'eleve' => $user_info['extId']
				]);

			if (!$cours)
			{
				// Create a new one only if it doesn't exist already
				dump("No course found for event '". $event_id ."' and student '". $user_info['extId']  ."'.\nCreating one...");
				$cours = new Cours();
			}


			// Unecessary details (but mandatory for debug)
			$eleve = $this->entityManager->getRepository('App\Entity\Eleve')->findOneBy(
				[
					'id' => $this->getInternalBBBId($user_info['extId'])
				]);
			if (!$eleve)
			{
				$eleve = new Eleve();
				$eleve->setId($this->getInternalBBBId($user_info['extId']));
			}
			$cours->setEleve($eleve);

			// Update the fields
//			$cours->setAnswers($user_info['answers']);
			$cours->setTalkTime($user_info['talk']['totalTime']);
			$cours->setEmojis($user_info['emojis']);
			$cours->setMessageCount($user_info['totalOfMessages']);
			$user_activity = $this->getUserActivity($user_info);
			$cours->setStartTime($user_activity['firstConnected']);
			$cours->setEndTime($user_activity['lastLeft']);
			$cours->setOnlineTime($user_activity['totalOnlineTime']);
			$cours->setConnectionCount($user_activity['connectionCount']);
			$cours->setWebcamTime($this->getWebcamTime($user_info)['totalTime']);

			print_r($cours);
			$this->entityManager->persist($cours);
			$this->entityManager->persist($eleve);
		}


		$this->entityManager->persist($meeting);
		$this->entityManager->flush();

		dump("Successfully imported '". $dashboard_path ."'");
	}

	// Returns the  and the connectionCount from the intIds array
    private function getWebcamTime($user_info) : array
    {
		$total_webcam_time = 0;
		foreach ($user_info['webcams'] as $webcam)
		{
			$total_webcam_time += $webcam['stoppedOn'] - $webcam['startedOn'];
		}

		return [ 'totalTime' => $total_webcam_time ] ;
    }

	// Returns the totalOnlineTime and the connectionCount from the intIds array
    private function getUserActivity($user_info) : array
    {
		$first_connected = 0;
		$last_left = -1;

		$connection_count = 0;
		$total_online_time = 0;

		foreach ($user_info['intIds'] as $connection)
		{
			if ($connection['registeredOn'] < $first_connected)
			{
				$first_connected = $connection['registeredOn'];
			}
			if ($connection['leftOn'] > $last_left || $last_left < 0 )
			{
				$last_left = $connection['leftOn'];
			}
			$total_online_time += $connection['leftOn'] - $connection['registeredOn'];
			$connection_count ++;
		}

		return [
			'totalOnlineTime' => $total_online_time,
			'connectionCount' => $connection_count,
			'firstConnected' => $first_connected,
			'lastLeft' => $last_left,
		];
    }


	private function getInternalBBBId(string $externalId) : int
	{
        $data = explode('_',$externalId);
        $id = base64_decode($data[0]);
        if($data[1] === hash('adler32',$id)) {
            return $id;
        }
        
        return null;
    }
}
