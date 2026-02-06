<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Pokemon;

interface PokemonRepository
{
    /**
     * @return list<Pokemon>
     */
    public function findAll(): array;
}
