<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\UserService;
use Framework\Environment\Environment;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    public function __construct(
        private readonly UserService $groupService,
        private readonly Environment $environment,
    ) {
        parent::__construct();
    }

    public function getName(): ?string
    {
        return 'app:test';
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('test');
        $output->writeln($this->environment->getVariable('ELASTIC_CONFIG'));
        $output->writeln($this->groupService->get());

        return 1;
    }
}
