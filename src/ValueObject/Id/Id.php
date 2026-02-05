<?php

declare(strict_types=1);

namespace App\ValueObject\Id;

interface Id
{
    public static function fromInt(int $id): static;

    public function toString(): string;
}
