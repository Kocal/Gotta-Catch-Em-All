<?php

declare(strict_types=1);

namespace App\Domain\Data\ValueObject;

use Webmozart\Assert\Assert;

final readonly class Username implements \Stringable
{
    /**
     * @var non-empty-string
     */
    public string $value;

    public function __construct(
        string $value
    ) {
        Assert::stringNotEmpty($value);

        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
