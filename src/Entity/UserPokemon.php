<?php

declare(strict_types=1);

namespace App\Entity;

use App\ValueObject\Id\PokemonId;
use App\ValueObject\Id\UserId;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Clock\DatePoint;

#[ORM\Entity()]
class UserPokemon
{
    #[ORM\Id]
    #[ORM\Column]
    public private(set) UserId $userId;

    #[ORM\Id]
    #[ORM\Column]
    public private(set) PokemonId $pokemonId;

    #[ORM\Column]
    private DatePoint $createdAt;

    public static function create(UserId $userId, PokemonId $pokemonId): self
    {
        $self = new self();
        $self->userId = $userId;
        $self->pokemonId = $pokemonId;
        $self->createdAt = new DatePoint();

        return $self;
    }
}
