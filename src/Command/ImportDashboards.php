<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
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
	case NoCreateEleve = "Prevent Create Eleve";
	case NoCreateCours = "Prevent Create Cours";
	case Unknown = "Unknown Error";

	public function getReturnCodeMessage(){

		return match($this){
			DashCodeStatus::OK => "",
			DashCodeStatus::NoRecordId => "There are no recordId for the following meeting(s)",
			DashCodeStatus::DashboardNotFound => "No dashboard could be found for the following meeting(s)",
			DashCodeStatus::MultipleDashboards => "Multiple dashboard have been found for the following meeting(s)",
			DashCodeStatus::UnmatchedMeetingId => "The meeting_id in the existing database does not match the extId in the dashboard for the following meeting(s)",
			DashCodeStatus::NoBindedEventToMeeting => "There are no binded event for the following meeting(s)",
			DashCodeStatus::NoCreateEleve => "No eleve could be found for the following meeting(s) (the prevent create option is set to TRUE)",
			DashCodeStatus::NoCreateCours => "No cours could be found for the following meeting(s) (the prevent create option is set to TRUE)",
			DashCodeStatus::Unknown => ""
		};
	}
}

class ImportDashboards extends Command
{
    private $entityManager;
	private $defaultDashboardDir;
	private SymfonyStyle $io;

    protected static $defaultName = 'app:import-dashboards';
    protected static $defaultDescription = 'Import the BBB JSON dashboards into the Lutice database';


    public function __construct(EntityManagerInterface $entityManager, string $defaultDashboardDir){
        $this->entityManager = $entityManager;
		$this->defaultDashboardDir = $defaultDashboardDir;
		parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('This command allows you to import the BBB JSON dashboards into the database');
        $this->addArgument('DashboardsDirectory', InputArgument::OPTIONAL, 'The directory path of the JSONs location', $this->defaultDashboardDir);
		$this->addOption('force-refresh', 'f', InputOption::VALUE_NONE, 'Forces all dashboards to be re-imported by ignoring the dashboardReady flag');
		$this->addOption('prevent-create', 'p', InputOption::VALUE_OPTIONAL, 'Prevents the creation of new Eleves and Cours if they do not exist [all, eleve, cours, none]', 'none');
		$this->addOption('compute-activity-lvl', 'a', InputOption::VALUE_REQUIRED, 'Choose or not to compute activity levels to save time and resources [all, nullOnly, none]', 'all');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
		$this->io = new SymfonyStyle($input, $output);
		
		// Get the args and options
        $dashboard_dir = $input->getArgument('DashboardsDirectory');
		$ignore_ready_flag = $input->getOption('force-refresh');
		$prevent_create = $input->getOption('prevent-create');
		$compute_activity_levels = $input->getOption('compute-activity-lvl');

		// Check the prevent-create option
		if (!$prevent_create)
		{
			// Default value
			$prevent_create = 'all';
		}
		if (!in_array($prevent_create, ['all', 'eleve', 'cours', 'none']))
		{
			$this->io->error([
				"The 'prevent-create' option must be one of the following values: 'all', 'eleve', 'cours'.",
				"You provided the value '". $prevent_create ."'",
				"Please provide a valid value (no value provided is the same as 'all')."
			]);
			return Command::FAILURE;
		}

		// Check the ignore-activity-lvl option
		if (!in_array($compute_activity_levels, ['all', 'existingOnly', 'none']))
		{
			$this->io->error([
				"The 'ignore-activity-lvl' option must be one of the following values: 'all', 'existingOnly'.",
				"You provided the value '". $compute_activity_levels ."'",
				"Please provide a valid value (no value provided is the same as 'none')."
			]);
			return Command::FAILURE;
		}

        $this->io->title('Importing dashboards from directory "' . $dashboard_dir . '"');

		if (!is_dir($dashboard_dir))
		{
			$this->io->error([
				"The directory '". $dashboard_dir ."' does not exist.",
				"Please provide a valid directory path in the .env file or as the argument."
			]);
			return Command::FAILURE;
		}

		if ($prevent_create != 'none'){
			// Make a note for the user about the prevent-create option
			$this->io->note([
				"The 'prevent-create' option is set to '". $prevent_create ."'"
			]);
		}
		
		if ($ignore_ready_flag){
			$this->io->warning("The 'ignoreReadyFlag' option is set to TRUE. All dashboards will be re-imported.");
			$this->io->section("Fetching all meetings...");
		}
		else
			$this->io->section("Fetching all non-ready meetings...");
	
		// Get all the meetings according to the options 
		$meetings = $ignore_ready_flag ?
			$this->entityManager->getRepository('App\Entity\Meeting')->findAll() :
			$this->entityManager->getRepository('App\Entity\Meeting')->findBy(['dashboardReady' => false]);

		if (count($meetings) == 0)
		{
			if ($ignore_ready_flag)
				$this->io->info("There are no meeting in the database.");
			else
				$this->io->info("All meetings are already up to date.");
			return Command::SUCCESS;
		}

		if ($ignore_ready_flag)
			$this->io->info('Found ' . count($meetings) . ' meetings.');
		else
			$this->io->info('Found ' . count($meetings) . ' meetings waiting to be updated.');
		
		
		$result = $this->io->confirm("Do you want to update these meetings?", true);
		if (!$result)
		{
			$this->io->warning("Aborted by user.");
			return Command::SUCCESS;
		}

		// Prepare the status buffer (for user feedback)
		$status_meetings = [];
		foreach (DashCodeStatus::cases() as $code_status)
			$status_meetings[$code_status->value] = [];

		foreach ($meetings as $meeting) {

			// Check if meeting has a recordId
			if (!$meeting->getRecordId()){
				$this->io->caution([
					DashCodeStatus::NoRecordId->getReturnCodeMessage(),
					"id = " . $meeting->getId() . "\nmeeting_id = " . $meeting->getMeetingId()
			]);
				continue;
			}

			// Find all the JSON files in the directory
			$path = $dashboard_dir . '/' .$meeting->getRecordId(). '/*.json';
			$this->io->section('Looking for JSON files as "'.$path.'"...');
			$dashboard_files = glob($path);

			$n_files = count($dashboard_files);
			if($n_files < 1) {
				$status_meetings[DashCodeStatus::DashboardNotFound->value][] = $meeting;
				$this->io->caution(DashCodeStatus::DashboardNotFound->getReturnCodeMessage());
				continue;
			}
			else if($n_files > 1){
				$status_meetings[DashCodeStatus::MultipleDashboards->value][] = $meeting;
				$this->io->caution(DashCodeStatus::MultipleDashboards->getReturnCodeMessage());
				continue;
			}

			$dashboard_file = $dashboard_files[0];

            $this->io->section("Importing dashboard " . $dashboard_file . "...");
            $return_code = $this->importDashboardToMeeting($meeting, $prevent_create, $dashboard_file, $compute_activity_levels);

			$status_meetings[$return_code->value][] = $meeting;

			if ($return_code == DashCodeStatus::OK){
				if ($compute_activity_levels != 'none')
					$this->computeUserActivities($meeting);

				$meeting->setDashboardReady(true);
				$this->entityManager->persist($meeting);
				$this->entityManager->flush();
			}
        }

		$this->io->title("Dashboard Import summary");

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

				$this->io->text($error_text);
			}
			$this->io->error([
				"Failed to update ". count($meetings) - count($status_meetings[DashCodeStatus::OK->value]) ." out of ". count($meetings) ." meetings.",
			]);
			// return Command::FAILURE;
		}

		$success_imports = count($status_meetings[DashCodeStatus::OK->value]);
		if ($success_imports > 0){
			$this->io->success('Successfully imported '. $success_imports .' dashboards to the existing database.');
			return Command::SUCCESS;
		}

		return Command::FAILURE;
    }

    protected function importDashboardToMeeting($meeting, $prevent_create, $dashboard_path) : DashCodeStatus 
    {
		$this->io->text("Serializing '". $dashboard_path ."'...");
        // Serialze the JSON file into an nested array
        $dashboard = json_decode(file_get_contents($dashboard_path), true);
		if ($meeting->getMeetingId() != $dashboard['extId'])
		{
			$this->io->caution(DashCodeStatus::UnmatchedMeetingId->getReturnCodeMessage());
			return DashCodeStatus::UnmatchedMeetingId;
		}
		$this->io->newLine();
		$this->io->text("Serialized '". $dashboard['name'] . "' for meeting (" .$dashboard['extId']. ").");

		$event = $meeting->getEvent();
		if (!$event)
		{
			$this->io->caution([
				DashCodeStatus::NoBindedEventToMeeting->getReturnCodeMessage(),
				"No event found for meeting (id = ". $meeting->getId() .")",
				"Meeting_id = ". $meeting->getMeetingId() ."",
				"Please create an event for this meeting before importing the dashboard."
			]);
			return DashCodeStatus::NoBindedEventToMeeting;
		}

		$this->io->section("Importing infos...");

		$meeting->setMeetingName($dashboard['name']);
        $meeting->setStartTime((new \DateTime())->setTimestamp((int)($dashboard['createdOn']/1000)));
        $meeting->setEndTime((new \DateTime())->setTimestamp((int)($dashboard['endedOn']/1000)));

		$start_time = $meeting->getStartTime();
		$end_time = $meeting->getEndTime();
		$meeting->setDuration($end_time->getTimestamp() - $start_time->getTimestamp());

        $this->entityManager->persist($meeting);
        $this->entityManager->flush();

		$this->io->text("Saved meeting '". $meeting->getMeetingId() ."'.");
		$this->io->section("Importing courses...");

        foreach ($dashboard['users'] as $user_info)
		{
			$this->io->section("'". $user_info['name'] ."'");
			// Find or define the ELEVE
			$eleve_id = $this->getInternalBBBId($user_info['extId']);
			$this->io->text("Finding student of ID: ". $eleve_id ."...");
			$eleve = $this->entityManager->getRepository('App\Entity\Eleve')->findOneBy(
				[
					'id' => $eleve_id
				]);

			if (!$eleve)
			{
				if ($prevent_create == 'eleve' || $prevent_create == 'all')
				{
					$this->io->caution([
						"No student found for '". $eleve_id ."'.",
						"Prevent create option for eleve is set to TRUE."
					]);
					return DashCodeStatus::NoCreateEleve;
				}
				$eleve = new Eleve();
				$eleve->setId($eleve_id); // Useless, the id is auto-generated and cannot be changed
				$fullname = explode(" ", $user_info['name']);
				$eleve->setFirstName($fullname[0]);
				if (array_key_exists(1, $fullname)) {
					$eleve->setLastName($fullname[1]);
				}
				$this->entityManager->persist($eleve);
				$this->entityManager->flush();
				$this->io->warning([
					"No student found for '". $eleve_id ."'.",
					"Created temporary student (id = ". $eleve->getId() .")",
					"If you wish to save it, change this student's id from ". $eleve->getId() ." to ". $eleve_id ." in the database."
				]);
			}

			$this->io->text("Finding course for event '". $event->getId() ."' and student '". $eleve->getId() ."'...");
			// Find or define the COURS
			$cours = $this->entityManager->getRepository('App\Entity\Cours')->findOneBy(
				[
					'event' => $event,
					'eleve' => $eleve
				]);

			if (!$cours)
			{
				if ($prevent_create == 'cours' || $prevent_create == 'all')
				{
					$this->io->caution([
						"No course found for event '". $event->getId() ."' and student '". $eleve->getId() ."'.",
						"Prevent create option for cours is set to TRUE."
					]);
					return DashCodeStatus::NoCreateCours;
				}
				// Create a new one only if it doesn't exist already
				$this->io->note("No course found for event '". $event->getId() ."' and student '". $eleve->getId() ."'. Creating one...");
				$cours = new Cours();
				$cours->setEvent($event);
				$cours->setEleve($eleve);
				$this->entityManager->persist($cours);
				$this->entityManager->flush();
			}

			// Update the fields
			$cours->setTalkTime($user_info['talk']['totalTime']);
			if ($user_info['emojis'] && count($user_info['emojis']) > 0){
				$array_emojis = $user_info['emojis'];
				$cours->setEmojis($this->formatEmojis($array_emojis));
			}
			$cours->setMessageCount($user_info['totalOfMessages']);
			$cours->setWebcamTime($this->getWebcamTime($user_info)['totalTime']);

			$user_activity = $this->getUserActivity($user_info);
			$cours->setStartTime((new \DateTime())->setTimestamp((int)$user_activity['firstConnected']/1000));
			$cours->setEndTime((new \DateTime())->setTimestamp((int)$user_activity['lastLeft']/1000));
			$cours->setOnlineTime($user_activity['totalOnlineTime']);
			$cours->setConnectionCount($user_activity['connectionCount']);

			$this->entityManager->persist($cours);
			$this->entityManager->flush();
			$this->io->newLine();
			$this->io->text("Saved course (id = ". $cours->getId() .") '". $cours ."'");
		}

		$this->io->newLine();
		$this->io->note("Successfully imported '". $dashboard_path ."'!");

		return DashCodeStatus::OK;
	}

	private function formatEmojis(?array $emojis) : ?array
	{
		if (!$emojis)
			return null;

		$emojis_formated = [];
		foreach ($emojis as $emoji)
		{
			if (array_key_exists($emoji['name'], $emojis_formated))
			{
				$emojis_formated[$emoji['name']]['count'] += 1;
				$emojis_formated[$emoji['name']]['timestamps'][] = $emoji['sentOn'];
			}
			else
			{
				$emojis_formated[$emoji['name']]['count'] = 1;
				$emojis_formated[$emoji['name']]['timestamps'] = [$emoji['sentOn']];
			}
		}
		return $emojis_formated;
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

	// This function should be used AFTER the import of the dashboard because we need all the courses to compute the max values
	private function computeUserActivities($meeting) : void
	{
		$all_courses = $this->entityManager->getRepository('App\Entity\Cours')->findBy([ 'event' => $meeting->getEvent() ]);

		if (!$all_courses || count($all_courses) < 1)
		{
			$this->io->warning([
				"No courses found for the event '". $meeting->getEvent()->getId() ."'",
				"Cannot compute the activity level of the users."
			]);

			return;
		}

		// Compute the activity level of the user within the meeting
		// The activity level is calculated by the sum of 5 factors each between 0 min and 2 max:

		// 1. The online time factor (compared to the total meeting time)
		// 2. The talk time factor (compared to the most talkative user (teacher excluded))
		// 3. The messages count factor (compared to the most messager user (teacher excluded))
		// 4. The emojis factor (compared to the most emoji user (teacher excluded))
		// 5. The raised hand factor (compared to the most hand-raised user (teacher excluded))

		// The factors are calculated as follows:
		// - The online time factor is the ratio of the user's online time to the total meeting time
		// - The talk time factor is the ratio of the user's talk time to the most talkative user's talk time
		// - The messages count factor is the ratio of the user's messages count to the most messager user's messages count
		// - The emojis factor is the ratio of the user's emojis count to the most emoji user's emojis count
		// - The raised hand factor is the ratio of the user's raised hand count to the most hand-raised user's raised hand count

		// The factors are then multiplied by 2 to get a value between 0 and 2
		$this->io->section("Fetching the max values for the factors...");

		// Let's start by getting the max values for each factor
		$max_online_time = 0;
		$max_talk_time = 0;
		$max_message_count = 0;
		$max_emojis = 0;
		$max_raised_hand = 0;

		// Get the max values for the emojis
		foreach ($all_courses as $user)
		{
			// There is for the moment no way to know if the user is a teacher or not
			// if ($user->isTeacher())
			// 	continue;

			$max_online_time = max($max_online_time, $user->getOnlineTime());
			$max_talk_time = max($max_talk_time, $user->getTalkTime());
			$max_message_count = max($max_message_count, $user->getMessageCount());
			
			// Count the emojis by hand because the values are inside the key [emoji-name]->count
			$emojis = $user->getEmojis();
			$total_user_emojis = 0;
			$total_user_hands = 0;
			if ($emojis)
			{
				foreach ($emojis as $name => $emoji)
				{
					if ($name == 'raiseHand')
					{
						$total_user_hands += $emoji['count'];
					}
					else
					{
						$total_user_emojis += $emoji['count'];
					}
				}
			}
			
			$max_emojis = max($max_emojis, $total_user_emojis);
			$max_raised_hand = max($max_raised_hand, $total_user_hands);
		}

		$this->io->section("Computing the activity level of the users...");

		// Now we can compute the factors
		foreach ($all_courses as $user)
		{
			$online_time_points = $max_online_time == 0 ? 0 : 2 * $user->getOnlineTime() / $max_online_time;
			$talk_time_points = $max_talk_time == 0 ? 0 : 2 * $user->getTalkTime() / $max_talk_time;
			$message_count_points = $max_message_count == 0 ? 0 : 2 * $user->getMessageCount() / $max_message_count;
			$emojis_points = 0;
			$raised_hand_points = 0;

			$total_emojis = 0;
			foreach ($user->getEmojis() as $emoji)
			{
				if($emoji['name'] != 'raiseHand')
				{
					$total_emojis += $emoji['count'];
				}
				else
				{
					$raised_hand_points = $max_raised_hand == 0 ? 0 : 2 * $emoji['count'] / $max_raised_hand;
				}
			}
			$emojis_points = $max_emojis == 0 ? 0 : 2 * $total_emojis / $max_emojis;

			$user->setActivityLevel($online_time_points + $talk_time_points + $message_count_points + $emojis_points + $raised_hand_points);
			$this->entityManager->persist($user);
			$this->io->text("Saved user '". $user->getId() ."' with activity level ". $user->getActivityLevel());
		}
		$this->io->text("Saved all users. Flushing...");
		$this->entityManager->flush();
		$this->io->text("Done.");
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
