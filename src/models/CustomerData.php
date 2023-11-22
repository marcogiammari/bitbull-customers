<?php

declare(strict_types=1);

namespace Models;

class CustomerData
{

    public function __construct(
        private string $id,
        private string $country,
        private string $name,
        private string $regNo,
    ) {
    }

    public function values()
    {
        return [
            $this->id,
            $this->country,
            $this->name,
            $this->regNo,
        ];
    }
}
