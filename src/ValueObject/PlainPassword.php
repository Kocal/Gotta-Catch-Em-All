<?php

declare(strict_types=1);

namespace App\ValueObject;

use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Webmozart\Assert\Assert;

final readonly class PlainPassword
{
    /**
     * @var non-empty-string
     */
    private string $value;

    public function __construct(
        string $value
    ) {
        Assert::stringNotEmpty($value);
        Assert::minLength($value, 8, 'Password must be at least %2$s characters long.');

        $this->value = $value;
    }

    /**
     * Hash the plain password using the provided password hasher.
     *
     * @return non-empty-string The hashed password
     */
    public function hash(PasswordHasherInterface $passwordHasher): string
    {
        return $passwordHasher->hash($this->value) ?: throw new \RuntimeException('The hashed password cannot be empty.');
    }
}
