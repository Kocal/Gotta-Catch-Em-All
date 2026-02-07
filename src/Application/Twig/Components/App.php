<?php

namespace App\Application\Twig\Components;

use App\Domain\Repository\PokemonRepository;
use App\Domain\Repository\UserPokemonRepository;
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
    )
    {
    }

    public function getPokemons(): array
    {
        return $this->pokemonRepository->findAll();
    }

    public function getCaughtPokemonIds(): array
    {

    }
}
