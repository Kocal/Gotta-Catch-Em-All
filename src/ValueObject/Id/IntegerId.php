<?php

declare(strict_types=1);

namespace App\ValueObject\Id;

interface IntegerId
{
    public function toString(): string;
}
