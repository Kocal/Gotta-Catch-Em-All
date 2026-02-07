<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Data\ValueObject\Username;

interface UserRepository
{
    public function hasUserWithUsername(Username $username): bool;
}
