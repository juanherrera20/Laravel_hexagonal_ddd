<?php

namespace Src\IdentityAndAccess\User\Domain\Entities;

use Src\IdentityAndAccess\User\Domain\ValueObjects\UserId;
use Src\IdentityAndAccess\User\Domain\ValueObjects\UserName;
use Src\IdentityAndAccess\User\Domain\ValueObjects\UserEmail;
use Src\IdentityAndAccess\User\Domain\ValueObjects\UserPassword;

class User
{
    private ?UserId $id; // Esta entidad la trabajamos con ID para ver los distintos planteamientos
    private UserName $name;
    private UserEmail $email;
    private UserPassword $password;


    public function __construct(
        ?UserId $id,
        UserName $name,
        UserEmail $email,
        UserPassword $password
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function id(): UserId 
    {
        return $this->id;
    }

    public function name(): UserName 
    {
        return $this->name;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function password(): UserPassword 
    {
        return $this->password;
    }
}