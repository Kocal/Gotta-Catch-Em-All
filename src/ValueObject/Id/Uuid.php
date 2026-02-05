<?php

declare(strict_types=1);

namespace App\ValueObject\Id;

interface Uuid
{
    public static function fromString(string $uuid): static;

    public function toString(): string;

    public function toRfc4122(): string;

    public function toBinary(): string;
}
