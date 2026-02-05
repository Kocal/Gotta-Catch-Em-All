<?php

declare(strict_types=1);

namespace App\Doctrine\Repository;

use App\Entity\User;
use App\Repository\UserRepository;
use App\ValueObject\Username;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final readonly class UserDoctrineRepository implements UserRepository
{
    /**
     * @var EntityRepository<User>
     */
    private EntityRepository $repository;

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
        $this->repository = $this->entityManager->getRepository(User::class);
    }

    public function hasUserWithUsername(Username $username): bool
    {
        return $this->repository->count([
            'username' => $username,
        ]) > 0;
    }
}
