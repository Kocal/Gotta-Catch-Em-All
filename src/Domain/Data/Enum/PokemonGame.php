<?php

declare(strict_types=1);

namespace App\Domain\Data\Enum;

enum PokemonGame: string
{
    case RedFire = 'red_fire';
    case GreenLeaf = 'green_leaf';
    case Ruby = 'ruby';
    case Sapphire = 'sapphire';
    case Emerald = 'emerald';

    public function getDisplayName(): string
    {
        return match ($this) {
            self::RedFire => 'RF',
            self::GreenLeaf => 'GL',
            self::Ruby => 'R',
            self::Sapphire => 'S',
            self::Emerald => 'E',
        };
    }
}
