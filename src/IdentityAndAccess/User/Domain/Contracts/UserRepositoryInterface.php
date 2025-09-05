<?php

declare(strict_types=1);

namespace Src\IdentityAndAccess\User\Domain\Contracts;

use Src\IdentityAndAccess\User\Domain\Entities\User;

interface UserRepositoryInterface
{
    public function register(User $user): array;

    public function findById(int $id): ?User;

    public function login(string $email, string $password): array;
 
    // public function logout(): bool;  // Se maneja Directamente en el controlador

    // public function findByToken(): ?User;
}
