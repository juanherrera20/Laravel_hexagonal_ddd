<?php

namespace Src\IdentityAndAccess\User\Infrastructure\Mappers;

use JsonSerializable;
use Src\IdentityAndAccess\User\Domain\Entities\User;

final class UserDto implements JsonSerializable
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email
        //el password no se expone en los Endpoints
    ) { }


    // Crea un UserDto
    public static function fromEntity(User $user): self
    {
        return new self(
            $user->id()->value(),   
            $user->name()->value(),
            $user->email()->value()
        );
    }

    // Mapea una colección de entidades User
    public static function collection(iterable $users): array
    {
        return array_map(
            fn (User $user) => self::fromEntity($user),
            is_array($users) ? $users : iterator_to_array($users)
        );
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
