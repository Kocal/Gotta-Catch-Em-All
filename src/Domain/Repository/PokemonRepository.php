<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Data\Model\Pokemon;

interface PokemonRepository
{
    /**
     * @return list<Pokemon>
     */
    public function findAll(): array;
}
