<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;


class UnreadyAllMeetings extends Command
{
    private $entityManager;
    
    protected static $defaultName = 'app:unready-all-meetings';
    protected static $defaultDescription = 'Set all "dashboardReady" fields to FALSE on the Lutice database';


    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
		parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('Inverse', InputArgument::OPTIONAL, 'Set TRUE instead of FALSE for all meetings', false);
        $this->setHelp('This command allows you to import the BBB JSON dashboards into the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
		$io = new SymfonyStyle($input, $output);
        $inverse = $input->getArgument('Inverse');
		$inverse_text = $inverse ? "TRUE" : "FALSE";
        $io->title('Set all meetings "dashboardReady" field to ' . $inverse_text);

		$io->section("Fetching all meetings...");

		$meetings = $this->entityManager->getRepository('App\Entity\Meeting')->findAll();
		if (count($meetings) == 0)
		{
			$io->info("There are no meeting in the database.");
			return Command::SUCCESS;
		}

		$io->info('Found ' . count($meetings) . ' meetings.');
		$result = $io->confirm("Do you really want to set 'dashboardReady' to " . $inverse_text . " for all (". count($meetings) .") meetings ", true);
		if (!$result)
		{
			$io->warning("Aborted by user.");
			return Command::FAILURE;
		}

		foreach ($meetings as $meeting) {
			$meeting->setDashboardReady($inverse);
			$this->entityManager->persist($meeting);
			$io->text("Set " . $meeting->getMeetingId() . " (id = " . $meeting->getId() . ")");
		}

		$this->entityManager->flush();

		return Command::SUCCESS;
    }
}