<?php

declare(strict_types=1);

namespace Src\CustomerManagement\Customer\Infrastructure\Repositories;

use Src\CustomerManagement\Customer\Domain\Contracts\CustomerRepositoryInterface;

use Src\CustomerManagement\Customer\Infrastructure\Mappers\CustomerDto;

use Src\CustomerManagement\Customer\Domain\Entities\Customer;
// use Src\CustomerManagement\Customer\Domain\ValueObjects\CustomerName;
// use Src\CustomerManagement\Customer\Domain\ValueObjects\CustomerEmail;

use App\Models\Customer as EloquentCustomer;
use Exception;

final class EloquentCustomerRepository implements CustomerRepositoryInterface
{
    public function create(Customer $customer): int
    {
        $model = new EloquentCustomer();
        $model->name = $customer->name()->value();
        $model->email = $customer->email()->value();
        $model->save();

        return $model->id;  //Return Customer ID created
    }

    public function findById(int $id): ?CustomerDto
    {
        $model = EloquentCustomer::find($id);

        if (!$model) {
            return null;
        }

        return CustomerDto::fromEloquent($model);
    }

    public function list(array $filters = []): array
    {
        $query = EloquentCustomer::query();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        $orderDir = $filters['orderDir'] ?? 'asc';
        $query->orderBy('created_at', $orderDir);

        $customers = $query->paginate(10);

        return [
            'data' => CustomerDto::collection($customers->items()),
            'pagination' => [
                'current_page' => $customers->currentPage(),
                'last_page'    => $customers->lastPage(),
                'per_page'     => $customers->perPage(),
                'total'        => $customers->total(),
            ]
        ];

    }

    public function update(int $id, Customer $customer): ?CustomerDto
    {
        $model = EloquentCustomer::find($id);
        if (!$model) {
            return null;
        }

        $model->name = $customer->name()->value();
        $model->email = $customer->email()->value();
        $model->save();

        return CustomerDto::fromEloquent($model);
    }

    public function delete(int $id): bool
    {
        $model = EloquentCustomer::find($id);
        if (!$model) return false;
        return (bool) $model->delete();
    }

}
