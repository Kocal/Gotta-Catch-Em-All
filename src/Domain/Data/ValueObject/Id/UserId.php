<?php

declare(strict_types=1);

namespace App\Domain\Data\ValueObject\Id;

final class UserId implements Uuid
{
    use UuidTrait;
}
