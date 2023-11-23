<?php

declare(strict_types=1);

namespace Model;

class Customer
{

    public function __construct(
        private string $id,
        private string $country,
        private string $name,
        private string $regNo,
        private array $address,
        private string $vatNo,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function values(): array
    {
        return [
            $this->id,
            $this->country,
            $this->name,
            $this->regNo,
            $this->vatNo
        ];
    }

    public function address(): array
    {
        return $this->address;
    }
}
