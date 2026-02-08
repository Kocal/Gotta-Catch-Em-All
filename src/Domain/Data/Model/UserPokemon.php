<?php

declare(strict_types=1);

namespace App\Domain\Data\Model;

use App\Domain\Data\ValueObject\Id\PokemonId;
use App\Domain\Data\ValueObject\Id\UserId;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Clock\DatePoint;

#[ORM\Entity()]
class UserPokemon
{
    #[ORM\Id]
    #[ORM\Column(type: 'user_id')]
    public private(set) UserId $userId;

    #[ORM\Id]
    #[ORM\Column(type: 'pokemon_id')]
    public private(set) PokemonId $pokemonId;

    #[ORM\Column(type: 'date_point')]
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
