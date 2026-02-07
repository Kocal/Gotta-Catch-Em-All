<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\DBAL\Types;

use App\Domain\Data\ValueObject\Id\UserId;

final class UserIdType extends AbstractUuidType
{
    public const string NAME = 'user_id';

    #[\Override]
    public function getName(): string
    {
        return self::NAME;
    }

    #[\Override]
    protected function getIdClass(): string
    {
        return UserId::class;
    }
}
