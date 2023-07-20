<?php

namespace App\Domain\Repositories;

use App\Contracts\FlightRepositoryInterface;
use App\Domain\Flight\Flight;
use Illuminate\Support\Facades\File;
use App\Exceptions\InvalidCsvFileException;

class CsvFlightRepository implements FlightRepositoryInterface
{
    public function findAll(string $filePath): array
    {

        if (!File::exists($filePath)) {
            throw new \RuntimeException("The file '{$filePath}' does not exist.");
        }

        $extension = strtolower(File::extension($filePath));
        if ($extension !== 'csv') {
            throw new \RuntimeException("The file '{$filePath}' is not a valid CSV file.");
        }


        $flights = [];

        $handle = fopen($filePath, 'r');
        if ($handle === false) {
            throw new \RuntimeException("Failed to open the file '{$filePath}'");
        }

        $header = fgetcsv($handle);
        if ($header === false || count($header) !== 3 || $header !== ['Countries', 'Status', 'Status Details']) {
            throw new InvalidCsvFileException();
        }

        while (($row = fgetcsv($handle)) !== false) {
            [$country, $status, $statusDetails] = $row;
            $flight = new Flight($country, $status, (int)$statusDetails);
            $flights[] = $flight;
        }

        fclose($handle);

        return $flights;
    }
}
