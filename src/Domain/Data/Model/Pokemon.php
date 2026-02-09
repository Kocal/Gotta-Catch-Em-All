<?php

declare(strict_types=1);

namespace App\Domain\Data\Model;

use App\Domain\Data\Enum\PokemonGame;
use App\Domain\Data\ValueObject\Id\PokemonId;

class Pokemon
{
    public private(set) PokemonId $id;

    /**
     * @var non-empty-string
     */
    public private(set) string $name;

    /**
     * @var list<PokemonGame>
     */
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

    public function getCatchableInGamesLabel(): string
    {
        return implode(' / ', array_map(
            fn (PokemonGame $game) => $game->value,
            $this->catchableInGames
        ));
    }
}
