<?php

namespace App\Command;

use App\Service\BorrowingService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Scheduler\Attribute\AsCronTask;

#[AsCommand(name: 'app:update-penalty')]
#[AsCronTask('0 6 * * *', schedule: 'default')]
class PenaltyCommand extends Command
{
    public function __construct(
        private readonly BorrowingService $borrowingService,
    ){
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->borrowingService->checkBorrowingsNotReturnedForPenalty();
        $output->writeln('Users penalty was updated');
        return Command::SUCCESS;
    }
}
