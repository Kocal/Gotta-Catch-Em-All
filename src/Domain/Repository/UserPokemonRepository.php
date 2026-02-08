<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Data\Model\UserPokemon;
use App\Domain\Data\ValueObject\Id\PokemonId;
use App\Domain\Data\ValueObject\Id\UserId;

interface UserPokemonRepository
{
    /**
     * @return array<value-of<PokemonId>, UserPokemon>
     */
    public function findAllCaughtPokemonsByUserId(UserId $userId): array;

    public function toggleCaught(UserId $userId, PokemonId $pokemonId): void;
}
