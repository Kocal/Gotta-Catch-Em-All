<?php

declare(strict_types=1);

namespace App\ValueObject\Id;

trait IdTrait
{
    private int $id;

    final private function __construct()
    {
    }

    // NB: This is only required to let Doctrine use ID object as primary key in his Identity Map
    public function __toString()
    {
        return $this->toString();
    }

    public static function fromInt(int $id): static
    {
        $self = new static();
        $self->id = $id;

        return $self;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function toString(): string
    {
        return (string) $this->id;
    }

    public function equals(self $to): bool
    {
        return $this->id === $to->id;
    }
}
