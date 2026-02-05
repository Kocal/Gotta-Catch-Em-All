<?php

declare(strict_types=1);

namespace App\Repository;

use App\ValueObject\Username;

interface UserRepository
{
    public function hasUserWithUsername(Username $username): bool;
}
