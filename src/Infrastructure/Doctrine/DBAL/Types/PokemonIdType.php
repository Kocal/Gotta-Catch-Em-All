<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\DBAL\Types;

use App\Domain\Data\ValueObject\Id\PokemonId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Exception\InvalidType;
use Doctrine\DBAL\Types\Type;

final class PokemonIdType extends Type
{
    public const string NAME = 'pokemon_id';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL([
            'unsigned' => true,
        ] + $column);
    }

    #[\Override]
    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): mixed
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof PokemonId) {
            return $value->id();
        }

        throw InvalidType::new($value, self::class, ['null', PokemonId::class]);
    }

    #[\Override]
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): mixed
    {
        if ($value === null) {
            return null;
        }

        if (is_int($value)) {
            return PokemonId::fromInt($value);
        }

        throw InvalidType::new($value, self::class, ['null', 'int', PokemonId::class]);
    }
}
