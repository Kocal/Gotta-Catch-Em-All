<?php

declare(strict_types=1);

namespace App\Application\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Pokemon
{
    public bool $isLogged;

    public \App\Domain\Data\Model\Pokemon $pokemon;

    public bool $isCaught;
}
