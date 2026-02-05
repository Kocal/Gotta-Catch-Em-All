<?php

declare(strict_types=1);

namespace App\Entity;

use App\Doctrine\DBAL\Types\PokemonIdType;
use App\Enum\PokemonGame;
use App\ValueObject\Id\PokemonId;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Pokemon
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: PokemonIdType::NAME, unique: true)]
    public private(set) PokemonId $id;

    /**
     * @var non-empty-string
     */
    #[ORM\Column(name: 'name', length: 100)]
    public private(set) string $name;

    /**
     * @var list<PokemonGame>
     */
    #[ORM\Column(name: 'catchable_in_games', length: 255, enumType: PokemonGame::class)]
    public private(set) array $catchableInGames;

    /**
     * @param non-empty-string $name
     * @param list<PokemonGame> $catchableInGames
     */
    public static function create(
        PokemonId $id,
        string $name,
        array $catchableInGames
    ): self {
        $self = new self();
        $self->id = $id;
        $self->name = $name;
        $self->catchableInGames = $catchableInGames;

        return $self;
    }
}
