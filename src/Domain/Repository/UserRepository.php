<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Data\Model\User;
use App\Domain\Data\ValueObject\Id\UserId;
use App\Domain\Data\ValueObject\Username;

interface UserRepository
{
    public function hasUserWithUsername(Username $username): bool;

    public function findById(UserId $value): ?User;
}
