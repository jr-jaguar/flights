<?php

namespace App\Domain\Flight;
class Flight
{
    private $countryCode;
    private $status;
    private $statusDetails;

    public function __construct(string $countryCode, string $status, int $statusDetails)
    {
        $this->countryCode = $countryCode;
        $this->status = $status;
        $this->statusDetails = $statusDetails;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getStatusDetails(): int
    {
        return $this->statusDetails;
    }
}
