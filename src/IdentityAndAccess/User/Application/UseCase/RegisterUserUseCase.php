<?php

declare(strict_types=1);

namespace Src\IdentityAndAccess\User\Application\UseCase;

use Src\IdentityAndAccess\User\Domain\Contracts\UserRepositoryInterface;
use Src\IdentityAndAccess\User\Domain\Entities\User;
use Src\IdentityAndAccess\User\Domain\ValueObjects\UserEmail;
use Src\IdentityAndAccess\User\Domain\ValueObjects\UserName;
use Src\IdentityAndAccess\User\Domain\ValueObjects\UserPassword;


final class RegisterUserUseCase
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $name, string $email, string $password): array
    {
        $user = new User(
            null,  //ID
            new UserName($name),
            new UserEmail($email),
            new UserPassword($password, $ishash = false)
        );

        return $this->repository->register($user);
    }
}
