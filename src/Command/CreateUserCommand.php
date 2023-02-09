<?php

declare(strict_types=1);

use App\Service\User\CreateUserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:user:create',
    description: 'Creates a new user.',
    hidden: false,
    aliases: ['app:add-user']
)]
class CreateUserCommand extends Command
{
    public function __construct(
        $name,
        private readonly CreateUserService $createUserService
    ) {
        parent::__construct($name);
    }

    public function configure(): void
    {
        $this
            ->setName('app:user:create')
            ->setDescription('Create new user in the system')
            ->addArgument('email', InputArgument::REQUIRED, 'User email')
            ->addArgument('password', InputArgument::REQUIRED, 'User password');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        $this->createUserService->create($email, $password);

        $output->writeln(sprintf('User [%s] has been created', $email));

        return Command::SUCCESS;
    }
}