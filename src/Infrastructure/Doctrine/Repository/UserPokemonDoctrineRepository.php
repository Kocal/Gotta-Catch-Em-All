<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Data\Model\UserPokemon;
use App\Domain\Data\ValueObject\Id\PokemonId;
use App\Domain\Data\ValueObject\Id\UserId;
use App\Domain\Repository\UserPokemonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final readonly class UserPokemonDoctrineRepository implements UserPokemonRepository
{
    /**
     * @var EntityRepository<UserPokemon>
     */
    private EntityRepository $repository;

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
        $this->repository = $this->entityManager->getRepository(UserPokemon::class);
    }

    public function findAllCaughtPokemonsByUserId(UserId $userId): array
    {
        $qb = $this->repository->createQueryBuilder('up', 'up.pokemonId')
            ->where('up.userId = :userId')
            ->setParameter('userId', $userId, 'user_id')
        ;

        return $qb->getQuery()->getResult();
    }

    public function toggleCaught(UserId $userId, PokemonId $pokemonId): bool
    {
        $userPokemon = $this->repository->findOneBy([
            'userId' => $userId,
            'pokemonId' => $pokemonId,
        ]);

        if ($userPokemon instanceof UserPokemon) {
            $this->entityManager->remove($userPokemon);
            $this->entityManager->flush();

            return false;
        }

        $userPokemon = UserPokemon::create($userId, $pokemonId);
        $this->entityManager->persist($userPokemon);
        $this->entityManager->flush();

        return true;
    }
}
