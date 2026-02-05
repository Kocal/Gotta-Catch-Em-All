<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserPokemonRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Clock\DatePoint;

#[ORM\Entity(repositoryClass: UserPokemonRepository::class)]
class UserPokemon
{
    #[ORM\Id]
    #[ORM\Column]
    private(set) int $userId;

    #[ORM\Id]
    #[ORM\Column]
    private(set) int $pokemonId;

    #[ORM\Column]
    private DatePoint $createdAt;

    public static function create(int $userId, int $pokemonId): self
    {
        $self = new self();
        $self->userId = $userId;
        $self->pokemonId = $pokemonId;
        $self->createdAt = new DatePoint();

        return $self;
    }
}
