<?php

declare(strict_types=1);

namespace App\Domain\Data\ValueObject\Id;

interface Id
{
    public static function fromInt(int $id): static;

    public function toString(): string;
}
