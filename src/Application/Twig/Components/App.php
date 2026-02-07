<?php

declare(strict_types=1);

namespace App\Application\Twig\Components;

use App\Domain\Data\Model\Pokemon;
use App\Domain\Repository\PokemonRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class App
{
    use DefaultActionTrait;

    public int $boxesCount = 14;

    public int $pokemonPerBox = 30;

    public function __construct(
        private readonly PokemonRepository $pokemonRepository,
    ) {
    }

    /**
     * @return list<Pokemon>
     */
    public function getPokemons(): array
    {
        return $this->pokemonRepository->findAll();
    }
}
