<?php

declare(strict_types=1);

namespace App\ValueObject\Id;

final class UserId implements Uuid
{
    use UuidTrait;
}
