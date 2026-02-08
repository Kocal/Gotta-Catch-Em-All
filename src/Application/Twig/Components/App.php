<?php

declare(strict_types=1);

namespace App\Application\Twig\Components;

use App\Domain\Data\Model\Pokemon;
use App\Domain\Data\Model\User;
use App\Domain\Data\Model\UserPokemon;
use App\Domain\Data\ValueObject\Id\PokemonId;
use App\Domain\Repository\PokemonRepository;
use App\Domain\Repository\UserPokemonRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class App
{
    public int $boxesCount = 14;

    public int $pokemonPerBox = 30;

    public ?UserInterface $user = null;

    public function __construct(
        private readonly PokemonRepository $pokemonRepository,
        private readonly UserPokemonRepository $userPokemonRepository,
    ) {
    }

    /**
     * @return list<Pokemon>
     */
    public function getPokemons(): array
    {
        return $this->pokemonRepository->findAll();
    }

    /**
     * @return array<value-of<PokemonId>, UserPokemon>
     */
    public function getCaughtPokemons(): array
    {
        if (! $this->user instanceof User) {
            return [];
        }

        return $this->userPokemonRepository->findAllCaughtPokemonsByUserId($this->user->id);
    }
}
