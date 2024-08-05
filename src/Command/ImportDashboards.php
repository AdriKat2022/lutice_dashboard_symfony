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
use App\Entity\Event;



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
            $output->writeln("\n-------------------------\nImporting " . $dashboardFile . "...");
            $this->importDashboard($dashboardFile, $output);
        }

        $output->writeln('Dashboards imported successfully!');

        return Command::SUCCESS;
    }

    protected function importDashboard($dashboard_path, $output) : void
    {
        // Serialze the JSON file into an nested array
        $dashboard = json_decode(file_get_contents($dashboard_path), true);
	    // $output->writeln(print_r($dashboard));

        // Get the meeting entity from the database
        $meeting = $this->entityManager->getRepository('App\Entity\Meeting')->findOneBy(['meetingId' => $dashboard['extId']]);

        if (!$meeting){
            $output->writeln("Failed to retrieve meeting '". $dashboard['extId'] ."'...");
			return;
        }	
		$output->writeln("Found meeting '". $meeting->getMeetingId() ."'. Importing...");
		$meeting->setMeetingName($dashboard['name']);

		$event = $meeting->getEvent();
  
		// Import the JSON dashboards
        $meeting->setStartTime((new \DateTime())->setTimestamp((int)($dashboard['createdOn']/1000)));
        $meeting->setEndTime((new \DateTime())->setTimestamp((int)($dashboard['endedOn']/1000)));
        $this->entityManager->persist($meeting);

		$output->writeln("Saved '". $meeting->getMeetingId() ."'.\n***********\nImporting courses...");

        foreach ($dashboard['users'] as $key => $user_info)
		{
			// Find or define the ELEVE
			$eleve_id = $this->getInternalBBBId($user_info['extId']);
			$output->writeln("***\nFinding student '". $eleve_id ."'...");
			$eleve = $this->entityManager->getRepository('App\Entity\Eleve')->findOneBy(
				[
					'id' => $eleve_id
				]);

			if (!$eleve)
			{
				$eleve = new Eleve();
				$eleve->setId($eleve_id);
				$this->entityManager->persist($eleve);
				$this->entityManager->flush();
				$output->writeln("No student found for '". $eleve_id ."'. Created temporary student (id = ". $eleve->getId() .")");
			}
			$fullname = explode(" ", $user_info['name']);
			$eleve->setFirstName($fullname[0]);
			if (array_key_exists(1, $fullname)) {
				$eleve->setLastName($fullname[1]);
			}
			$this->entityManager->persist($eleve);
			$this->entityManager->flush();


			// Find or define the COURS
			$cours = $this->entityManager->getRepository('App\Entity\Cours')->findOneBy(
				[
					'event' => $event,
					'eleve' => $eleve
				]);

			if (!$cours)
			{
				// Create a new one only if it doesn't exist already
				$output->writeln("No course found for event '". $event->getId() ."' and student '". $eleve->getId() ."'. Creating one...");
				$cours = new Cours();
				$cours->setEvent($event);
				$cours->setEleve($eleve);
			}
			$cours->setEleve($eleve);
			$this->entityManager->persist($cours);
			$this->entityManager->flush();

			// Update the fields
			// TODO : Get Answers
			$cours->setTalkTime($user_info['talk']['totalTime']);
			$cours->setEmojis($user_info['emojis']);
			$cours->setMessageCount($user_info['totalOfMessages']);
			$cours->setWebcamTime($this->getWebcamTime($user_info)['totalTime']);

			$user_activity = $this->getUserActivity($user_info);
			$cours->setStartTime((new \DateTime())->setTimestamp((int)$user_activity['firstConnected']/1000));
			$cours->setEndTime((new \DateTime())->setTimestamp((int)$user_activity['lastLeft']/1000));
			$cours->setOnlineTime($user_activity['totalOnlineTime']);
			$cours->setConnectionCount($user_activity['connectionCount']);

			$this->entityManager->persist($cours);
			$this->entityManager->flush();
			$output->writeln("Saved the course (id = ". $cours->getId() .") '". $cours ."'...");
		}

		$this->entityManager->persist($meeting);
		$this->entityManager->flush();
		$output->writeln("**********\nSaved the meeting (id = ". $meeting->getId() .") '". $meeting->getMeetingId() ."'");

		$output->writeln("Successfully imported '". $dashboard_path ."'");
	}

	// Returns the total time spent on webcams from the webcams array
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
		$first_connected = -1;
		$last_left = -1;

		$connection_count = 0;
		$total_online_time = 0;

		foreach ($user_info['intIds'] as $connection)
		{
			if ($connection['registeredOn'] < $first_connected || $first_connected < 0)
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
        $data = explode('_', $externalId);
        $id = base64_decode($data[0]);
        if($data[1] === hash('adler32', $id)) {
            return $id;
        }
        
        return null;
    }
}
