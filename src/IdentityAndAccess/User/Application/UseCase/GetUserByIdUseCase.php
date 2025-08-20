<?php

namespace Src\IdentityAndAccess\User\Application\UseCase;

use Src\IdentityAndAccess\User\Domain\Contracts\UserRepositoryInterface;

final class GetUserByIdUseCase
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id)
    {
        return $this->repository->findById($id);
    }
}
