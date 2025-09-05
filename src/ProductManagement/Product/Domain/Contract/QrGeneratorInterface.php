<?php

namespace Src\ProductManagement\Product\Domain\Contract;

use JsonSerializable;

interface QrGeneratorInterface
{
    public function generate(string $data): string;

}