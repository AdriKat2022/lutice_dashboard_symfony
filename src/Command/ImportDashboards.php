<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Cours;
use App\Entity\Eleve;

enum DashCodeStatus : string {
	case OK = "OK";
	case NoRecordId = "No Record Id";
	case DashboardNotFound = "Dashboard Not Found";
	case MultipleDashboards = "Multiple Dashboards";
	case UnmatchedMeetingId = "Meeting And Dashboard Ids Unmatched";
	case NoBindedEventToMeeting = "No Binded Event To Meeting";
	case Unknown = "Unknown Error";

	public function getReturnCodeMessage(){

		return match($this){
			DashCodeStatus::OK => "",
			DashCodeStatus::NoRecordId => "There are no recordId for the following meeting(s)",
			DashCodeStatus::DashboardNotFound => "No dashboard could be found for the following meeting(s)",
			DashCodeStatus::MultipleDashboards => "Multiple dashboard have been found for the following meeting(s)",
			DashCodeStatus::UnmatchedMeetingId => "The meeting_id in the existing database does not match the extId in the dashboard for the following meeting(s)",
			DashCodeStatus::NoBindedEventToMeeting => "There are no binded event for the following meeting(s)",
			DashCodeStatus::Unknown => ""
		};
	}
}

class ImportDashboards extends Command
{
    private $entityManager;
	private $defaultDashboardDir;
    
    protected static $defaultName = 'app:import-dashboards';
    protected static $defaultDescription = 'Import the BBB JSON dashboards into the Lutice database';


    public function __construct(EntityManagerInterface $entityManager, string $defaultDashboardDir){
        $this->entityManager = $entityManager;
		$this->defaultDashboardDir = $defaultDashboardDir;
		parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('DashboardsDirectory', InputArgument::OPTIONAL, 'The path of the dashboard JSON to import', $this->defaultDashboardDir);
        $this->setHelp('This command allows you to import the BBB JSON dashboards into the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
		$io = new SymfonyStyle($input, $output);
        $dashboard_dir = $input->getArgument('DashboardsDirectory');

		
        $io->title('Importing dashboards from directory "' . $dashboard_dir . '"');

		$io->section("Fetching all non-ready meetings...");

		// Get all the meetings that are not imported (dahboardReady = false)
		$meetings = $this->entityManager->getRepository('App\Entity\Meeting')->findBy(['dashboardReady' => false]);
		if (count($meetings) == 0)
		{
			$io->info("All meetings are already up to date.");
			return Command::SUCCESS;
		}

		$io->info('Found ' . count($meetings) . ' meetings waiting to be updated.');
		$result = $io->confirm("Do you want to update these meetings?", true);
		if (!$result)
		{
			$io->warning("Aborted by user.");
			return Command::FAILURE;
		}

		// Prepare the status buffer (for user feedback)
		$status_meetings = [];
		foreach (DashCodeStatus::cases() as $code_status)
			$status_meetings[$code_status->value] = [];

		foreach ($meetings as $meeting) {

			// Check if meeting has a recordId
			if (!$meeting->getRecordId()){
				$io->caution([
					DashCodeStatus::NoRecordId->getReturnCodeMessage(),
					"id = " . $meeting->getId() . "\nmeeting_id = " . $meeting->getMeetingId()
			]);
				continue;
			}

			// Find all the JSON files in the directory
			$path = $dashboard_dir . '/' .$meeting->getRecordId(). '/*.json';
			$io->section('Looking for JSON files as "'.$path.'"...');
			$dashboard_files = glob($path);

			$n_files = count($dashboard_files);
			if($n_files < 1) {
				$status_meetings[DashCodeStatus::DashboardNotFound->value][] = $meeting;
				$io->caution(DashCodeStatus::DashboardNotFound->getReturnCodeMessage());
				continue;
			}
			else if($n_files > 1){
				$status_meetings[DashCodeStatus::MultipleDashboards->value][] = $meeting;
				$io->caution(DashCodeStatus::MultipleDashboards->getReturnCodeMessage());
				continue;
			}

			$dashboard_file = $dashboard_files[0];

            $io->section("Importing dashboard " . $dashboard_file . "...");
            $return_code = $this->importDashboardToMeeting($meeting, $dashboard_file, $io);

			$status_meetings[$return_code->value][] = $meeting;
        }

		$io->title("Dashboard Import summary");

		// Make feedback to user
		if (count($status_meetings[DashCodeStatus::OK->value]) != count($meetings)){
			foreach ($status_meetings as $error_type => $failed_meetings)
			{
				if (count($failed_meetings) < 1 || $error_type == DashCodeStatus::OK->value) continue;
				$text_failure = [(string)$error_type . ":"];
				array_walk($failed_meetings, function (&$value, $key){
					$value = "(id = " . $value->getId() . ") " . $value->getMeetingId();
				});
				$error_text = array_merge($text_failure, $failed_meetings);

				$io->text($error_text);
			}
			$io->error([
				"Failed to update ". count($meetings) - count($status_meetings[DashCodeStatus::OK->value]) ." out of ". count($meetings) ." meetings.",
			]);
			// return Command::FAILURE;
		}

		$success_imports = count($status_meetings[DashCodeStatus::OK->value]);
		if ($success_imports > 0){
			$io->success('Successfully imported '. $success_imports .' dashboards to the existing database.');
			return Command::SUCCESS;
		}

		return Command::FAILURE;
    }

    protected function importDashboardToMeeting($meeting, $dashboard_path, $io) : DashCodeStatus 
    {
		$io->text("Serializing '". $dashboard_path ."'...");
        // Serialze the JSON file into an nested array
        $dashboard = json_decode(file_get_contents($dashboard_path), true);
		if ($meeting->getMeetingId() != $dashboard['extId'])
		{
			$io->caution(DashCodeStatus::UnmatchedMeetingId->getReturnCodeMessage());
			return DashCodeStatus::UnmatchedMeetingId;
		}
		$io->newLine();
		$io->text("Serialized '". $dashboard['name'] . "' for meeting (" .$dashboard['extId']. ").");

		$event = $meeting->getEvent();
		if (!$event)
		{
			$io->caution([
				DashCodeStatus::NoBindedEventToMeeting->getReturnCodeMessage(),
				"No event found for meeting (id = ". $meeting->getId() .")",
				"Meeting_id = ". $meeting->getMeetingId() ."",
				"Please create an event for this meeting before importing the dashboard."
			]);
			return DashCodeStatus::NoBindedEventToMeeting;
		}

		$io->section("Importing infos...");

		$meeting->setMeetingName($dashboard['name']);
        $meeting->setStartTime((new \DateTime())->setTimestamp((int)($dashboard['createdOn']/1000)));
        $meeting->setEndTime((new \DateTime())->setTimestamp((int)($dashboard['endedOn']/1000)));

        $this->entityManager->persist($meeting);
        $this->entityManager->flush();

		$io->text("Saved meeting '". $meeting->getMeetingId() ."'.");
		$io->section("Importing courses...");

        foreach ($dashboard['users'] as $user_info)
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
				$io->note("No course found for event '". $event->getId() ."' and student '". $eleve->getId() ."'. Creating one...");
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

		return DashCodeStatus::OK;
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

	// private function getAllNonImportedDashboards() : array
	// {
	// 	return array();
	// }

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
