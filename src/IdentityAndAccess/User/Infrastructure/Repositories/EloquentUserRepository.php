<?php

declare(strict_types=1);

namespace Src\IdentityAndAccess\User\Infrastructure\Repositories;

use App\Models\User as UserEloquent;
use Exception;
use Illuminate\Support\Facades\Hash;
use Src\IdentityAndAccess\User\Domain\Contracts\UserRepositoryInterface;
use Src\IdentityAndAccess\User\Domain\Entities\User;
use Src\IdentityAndAccess\User\Domain\ValueObjects\UserEmail;
use Src\IdentityAndAccess\User\Domain\ValueObjects\UserId;
use Src\IdentityAndAccess\User\Domain\ValueObjects\UserName;
use Src\IdentityAndAccess\User\Domain\ValueObjects\UserPassword;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function register(User $user): array
    {
        try {
            $model = [
                "name"=>$user->name()->value(), 
                "email"=>$user->email()->value(),
                "password"=>$user->password()->value()
            ];

            $userCreated = UserEloquent::create($model);

            $token = $userCreated->createToken('auth_token')->plainTextToken;

            return [
                "message" => "El Usuario Id: {$userCreated->id} fue creado con éxito",
                "token"   => $token
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function findById(int $id): ?User
    {
        try {
            $model = UserEloquent::find($id);

            if (!$model) {
                return null;
            }

            return new User(
                new UserId($model->id),
                new UserName($model->name),
                new UserEmail($model->email),
                new UserPassword($model->password, True)
            );
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function login(string $email, string $password): array
    {
        $model = UserEloquent::where('email', $email)->first();

        if (!$model || !Hash::check($password, $model->password)) {
            return [
                "message" => "Las Credenciales Son Incorrectas",
                "status"  => 401
            ];
        }

        $token = $model->createToken('auth_token')->plainTextToken;

        return [
            "message" => "Login Exitoso!",
            "token"   => $token,
            "user"    => [
                "id"    => $model->id,
                "name"  => $model->name,
                "email" => $model->email
            ]
        ];
    }

}





