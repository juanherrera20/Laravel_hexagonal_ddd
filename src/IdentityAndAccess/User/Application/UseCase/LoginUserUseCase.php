<?php

namespace Src\IdentityAndAccess\User\Application\UseCase;

use Src\IdentityAndAccess\User\Domain\Contracts\UserRepositoryInterface;

final class LoginUserUseCase
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $email, string $password): array
    {
        return $this->repository->login($email, $password);
    }
}
