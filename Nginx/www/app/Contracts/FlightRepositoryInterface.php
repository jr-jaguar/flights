<?php

namespace App\Contracts;

use App\Domain\Flight\Flight;

interface FlightRepositoryInterface
{
    public function findAll(string $filePath): array;
}
