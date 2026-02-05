<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\PokemonGame;
use App\Repository\PokemonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
class Pokemon
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', options: [
        'unsigned' => true,
    ])]
    public private(set) int $id;

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
        int $id,
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
