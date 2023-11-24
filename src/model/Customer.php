<?php

declare(strict_types=1);

namespace BitbullCustomers\Model;

class Customer
{

    public function __construct(
        private string $id,
        private string $country,
        private string $name,
        private string $regNo,
        private string $vatNo,
        private array $addressValues,
        private array $phoneNumbers = [],
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

    public function addressValues(): array
    {
        return $this->addressValues;
    }

    public function addPhoneNumbers(array $phoneNumbers): void
    {
        $this->phoneNumbers = $phoneNumbers;
    }

    public function phoneNumbers(): array
    {
        return $this->phoneNumbers;
    }
}
