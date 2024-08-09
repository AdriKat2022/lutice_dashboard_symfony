<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Meeting;
use App\Entity\Cours;

#[AsCommand(
    name: 'app:bdd-fix',
    description: 'Add a short description for your command',
)]
class BddFixCommand extends Command
{

    private $entityManager;
    private InputInterface $input;
    private SymfonyStyle $io;


    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
		parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Fixes the database from incoherences.')
            ->addOption('force-fix', 'f', InputOption::VALUE_NONE, 'Recomputes fields even if they are not null.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input = $input;
        $this->io = new SymfonyStyle($input, $output);
        $force_fix = $input->getOption('force-fix');

        $meetings = $this->entityManager->getRepository(Meeting::class)->findAll();
        if (count($meetings) === 0) {
            $this->io->success('No meetings found in the database.');
            return Command::SUCCESS;
        }

        $this->io->title('Fixing the database');
        if ($force_fix) {
            $this->io->warning('You are about to fix the database even if the fields are not null. This operation is irreversible.');
        }

        $confirm = $this->io->confirm("Found ". count($meetings) ." meetings, are you sure you want to fix the database ?", true);
        if (!$confirm) {
            $this->io->warning('Operation cancelled by user.');
            return Command::SUCCESS;
        }

        foreach ($meetings as $meeting) {
            $this->io->section('Fixing meeting '.$meeting->getMeetingName().' (id = '.$meeting->getId().')');
            $this->fixMeetingAndChildren($force_fix, $meeting);
        }

        $this->io->success('Database fixed.');

        return Command::SUCCESS;
    }

    protected function fixMeetingAndChildren($force_fix, $meeting)
    {
        // If the duration is not null and we are not forcing the fix, we skip the fix

        $old_duration = $meeting->getDuration();
        if ($force_fix || $old_duration === null) {
            // Get the milliseconds between the start and end time
            $start_time = $meeting->getStartTime();
            $end_time = $meeting->getEndTime();
            $duration = $end_time->getTimestamp() - $start_time->getTimestamp();

            // Update the meeting duration
            $meeting->setDuration($duration);
            $this->entityManager->persist($meeting);
            $this->entityManager->flush();
            $this->io->text("Fixed duration: $old_duration -> $duration");
        }

        // There is nothing to fix for the cours yet
    }
}
