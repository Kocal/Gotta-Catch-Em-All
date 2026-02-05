<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use App\ValueObject\PlainPassword;
use App\ValueObject\Username;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

#[AsCommand(
    name: 'app:create-admin',
    description: 'Create a new administrator.',
)]
class CreateAdminCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserRepository $userRepository,
        private readonly PasswordHasherFactoryInterface $passwordHasherFactory,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @var Username $username */
        $username = $io->ask('Username', null, function (mixed $value): Username {
            if (! is_string($value)) {
                throw new \RuntimeException('Username must be a string.');
            }

            $username = new Username($value);

            if ($this->userRepository->hasUserWithUsername($username)) {
                throw new \RuntimeException(sprintf('Username "%s" is already taken.', $username));
            }

            return $username;
        });

        /** @var PlainPassword $plainPassword */
        $plainPassword = $io->askHidden('Password', function (mixed $value): PlainPassword {
            if (! is_string($value)) {
                throw new \RuntimeException('Password must be a string.');
            }

            return new PlainPassword($value);
        });

        $user = User::create(
            username: $username->value,
            password: $plainPassword->hash($this->passwordHasherFactory->getPasswordHasher(User::class)),
            roles: ['ROLE_ADMIN']
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success('Admin created.');

        return Command::SUCCESS;
    }
}
