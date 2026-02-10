<?php

declare(strict_types=1);

namespace App\Application\Twig\Components;

use App\Domain\Data\Model\UserPokemon;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Pokemon
{
    public bool $isLogged;
    public \App\Domain\Data\Model\Pokemon $pokemon;
    /** @var array<int, UserPokemon> */
    public array $caughtPokemons;
}
