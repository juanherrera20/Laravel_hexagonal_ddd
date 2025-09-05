<?php

namespace Src\CustomerManagement\Customer\Infrastructure\Controllers;

use App\Http\Requests\CustomerPostRequest;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Src\CustomerManagement\Customer\Application\UseCase\CreateCustomerUseCase;
use Src\CustomerManagement\Customer\Application\UseCase\ListCustomersUseCase;
use Src\CustomerManagement\Customer\Application\UseCase\GetCustomerByIdUseCase;
use Src\CustomerManagement\Customer\Application\UseCase\UpdateCustomerUseCase;
use Src\CustomerManagement\Customer\Application\UseCase\DeleteCustomerUseCase;
use Src\CustomerManagement\Customer\Domain\ValueObjects\CustomerName;
use Src\CustomerManagement\Customer\Domain\ValueObjects\CustomerEmail;

final class CustomerController
{
    public function __construct(
        private CreateCustomerUseCase $createCustomer,
        private ListCustomersUseCase $listCustomers,
        private GetCustomerByIdUseCase $getCustomerById,
        private UpdateCustomerUseCase $updateCustomer,
        private DeleteCustomerUseCase $deleteCustomer
    ) {}

    public function store(CustomerPostRequest $request)
    {
        try {
            // Retrieve the validated input data...
            $validated = $request->validated();

            $result = $this->createCustomer->execute(
                new CustomerName($validated['name']),
                new CustomerEmail($validated['email'])
            );

            return response()->json([
                "message"=>"Customer Creado Con exito",
                "CustomerId"=>$result
            ], 201);

        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

    }

    public function index(Request $request)
    {
        $filters = [
            'name'     => $request->query('name'),
            'orderDir' => $request->query('orderDir', 'asc'),
        ];

        $result = $this->listCustomers->execute($filters);

        return $result;
    }

    public function show(int $id)
    {
        try {
            $result = $this->getCustomerById->execute($id);

            if (!$result) {
                return response()->json(['message' => 'Customer not found'], 404);
            }

            return $result;
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
        
    }

    public function update(CustomerPostRequest $request, int $id)
    {
        $validated = $request->validated();

        $result = $this->updateCustomer->execute(
            $id,
            $validated['name'],
            $validated['email']
        );

        if (!$result) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        return $result;
    }

    public function destroy(int $id)
    {
        $deleted = $this->deleteCustomer->execute($id);
        if (!$deleted) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        return response()->json(['message' => 'Customer deleted successfully']);
    }


}
