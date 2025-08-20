<?php

namespace Src\CustomerManagement\Customer\Infrastructure\Mappers;

use App\Models\Customer as CustomerEloquent;
use JsonSerializable;

final class CustomerDto implements JsonSerializable 
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email
    )
    { }
    
    // To Create new instance by model eloquent
    public static function fromEloquent(CustomerEloquent $model): self
    {
        return new self(
            $model->id,
            $model->name,
            $model->email
        );
    }

    // Mapping lists of products (Eloquent Model)
    public static function collection(iterable $customers): array
    {
        return array_map(fn ($customer) => self::fromEloquent($customer), $customers);
    }

    
    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}