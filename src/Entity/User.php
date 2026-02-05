<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    public private(set) Uuid $id;

    /**
     * @var non-empty-string
     */
    #[ORM\Column(length: 180, unique: true)]
    public private(set) string $username;

    /**
     * @var non-empty-list<non-empty-string> The user roles
     */
    #[ORM\Column]
    public private(set) array $roles {
        get {
            if (! in_array('ROLE_USER', $this->roles, true)) {
                $this->roles[] = 'ROLE_USER';
            }

            return $this->roles;
        }
    }

    /**
     * @var non-empty-string The hashed password
     */
    #[ORM\Column]
    public private(set) string $password;

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0" . self::class . "\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    /**
     * @param non-empty-string $username
     * @param non-empty-string $password
     * @param non-empty-list<non-empty-string> $roles
     */
    public static function create(string $username, string $password, array $roles): self
    {
        $self = new self();
        $self->id = Uuid::v7();
        $self->username = $username;
        $self->password = $password;
        $self->roles = $roles;

        return $self;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
