<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;
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
		$io = new SymfonyStyle($input, $output);
        $dashboard_path = $input->getArgument('DashboardsDirectory');

        $io->title('Importing dashboards from directory "' . $dashboard_path . '"');

        // Find all the JSON files in the directory
		$io->section('Looking for JSON files...');
        $dashboardFiles = glob($dashboard_path . '/*.json');
        $io->info('Found ' . count($dashboardFiles) . ' dashboards to import in directory "' . $dashboard_path . '".');
		$result = $io->confirm("Do you want to import these dashboards?", true);
		if (!$result)
		{
			$io->warning("Aborted by user.");
			return Command::FAILURE;
		}

		$failures = [];

// 		$io->progressStart(count($dashboardFiles));
        // Import each dashboard
        foreach ($dashboardFiles as $dashboardFile) {
            $io->section("Importing dashboard " . $dashboardFile . "...");
            if (!$this->importDashboard($dashboardFile, $io)){
				$failures[] = $dashboardFile;
			}
// 			$io->progressAdvance();
        }

// 		$io->progressFinish();
		if (count($failures) > 0){
			$text_failures = "";
			foreach ($failures as $failure)
			{
				$text_failures .= basename($failure) . "\n";
			}
			$io->error([
				"Failed to import ". count($failures) ." out of ". count($dashboardFiles) ." dashboards.",
				"Failed dashboards are :",
				$text_failures
			]);
			return Command::FAILURE;
		}

		if (count($dashboardFiles) == 0)
		{
			$io->info("No dashboards found in directory '". $dashboard_path ."'");
			return Command::SUCCESS;
		}
        $io->success('Successfully imported '. count($dashboardFiles) .' Dashboards to the existing database.');
        return Command::SUCCESS;
    }

    protected function importDashboard($dashboard_path, $io) : bool 
    {
		$io->text("Serializing '". $dashboard_path ."'...");
        // Serialze the JSON file into an nested array
        $dashboard = json_decode(file_get_contents($dashboard_path), true);
		$io->newLine();

		$io->text("Fetching '". $dashboard['name'] . "' (" .$dashboard['extId']. ") from the database...");
        // Get the meeting entity from the database
        $meeting = $this->entityManager->getRepository('App\Entity\Meeting')->findOneBy(['meetingId' => $dashboard['extId']]);

        if (!$meeting){
            $io->error("Failed to retrieve meeting '". $dashboard['extId'] ."'...");
			return false;
        }	
		$io->text("Found meeting (id = ". $meeting->getId() .") '". $meeting->getMeetingId() ."'.");

		$event = $meeting->getEvent();
		if (!$event)
		{
			$io->error([
				"No event found for meeting (id = ". $meeting->getId() .")",
				"Meeting_id = ". $meeting->getMeetingId() ."",
				"Please create an event for this meeting before importing the dashboard."
			]);
			return false;
		}

		$io->section("Importing infos...");

		$meeting->setMeetingName($dashboard['name']);
        $meeting->setStartTime((new \DateTime())->setTimestamp((int)($dashboard['createdOn']/1000)));
        $meeting->setEndTime((new \DateTime())->setTimestamp((int)($dashboard['endedOn']/1000)));

        $this->entityManager->persist($meeting);
        $this->entityManager->flush();

		$io->text("Saved meeting '". $meeting->getMeetingId() ."'.");
		$io->section("Importing courses...");

        foreach ($dashboard['users'] as $key => $user_info)
		{
			$io->section("'". $user_info['name'] ."'");
			// Find or define the ELEVE
			$eleve_id = $this->getInternalBBBId($user_info['extId']);
			$io->text("Finding student of ID: ". $eleve_id ."...");
			$eleve = $this->entityManager->getRepository('App\Entity\Eleve')->findOneBy(
				[
					'id' => $eleve_id
				]);

			if (!$eleve)
			{
				$eleve = new Eleve();
				$eleve->setId($eleve_id); // Useless, the id is auto-generated and cannot be changed
				$fullname = explode(" ", $user_info['name']);
				$eleve->setFirstName($fullname[0]);
				if (array_key_exists(1, $fullname)) {
					$eleve->setLastName($fullname[1]);
				}
				$this->entityManager->persist($eleve);
				$this->entityManager->flush();
				$io->warning([
					"No student found for '". $eleve_id ."'.",
					"Created temporary student (id = ". $eleve->getId() .")",
					"If you wish to save it, change this student's id from ". $eleve->getId() ." to ". $eleve_id ." in the database."
				]);
			}

			$io->text("Finding course for event '". $event->getId() ."' and student '". $eleve->getId() ."'...");
			// Find or define the COURS
			$cours = $this->entityManager->getRepository('App\Entity\Cours')->findOneBy(
				[
					'event' => $event,
					'eleve' => $eleve
				]);

			if (!$cours)
			{
				// Create a new one only if it doesn't exist already
				$io->caution("No course found for event '". $event->getId() ."' and student '". $eleve->getId() ."'. Creating one...");
				$cours = new Cours();
				$cours->setEvent($event);
				$cours->setEleve($eleve);
				$this->entityManager->persist($cours);
				$this->entityManager->flush();
			}

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
			$io->newLine();
			$io->text("Saved course (id = ". $cours->getId() .") '". $cours ."'");
		}

		$io->newLine();
		$io->note("Successfully imported '". $dashboard_path ."'!");

		return true;
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
