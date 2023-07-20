<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Domain\Repositories\CsvFlightRepository;
use App\Exceptions\InvalidCsvFileException;

class CsvFlightRepositoryTest extends TestCase
{
    public function testFindAllReturnsArrayOfFlights()
    {
        $filePath = __DIR__.'/files/flights.csv';
        $csvFlightRepository = new CsvFlightRepository();
        $flights = $csvFlightRepository->findAll($filePath);

        $this->assertIsArray($flights);
        $this->assertNotEmpty($flights);
        $this->assertInstanceOf(\App\Domain\Flight\Flight::class, $flights[0]);
    }

    public function testFindAllThrowsExceptionOnInvalidFile()
    {
        $content = "Countries,Status,Status Details\nLV,Cancel,20";
        $tempFilePath = __DIR__.'/files/test_flights.txt';
        file_put_contents($tempFilePath, $content);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage("The file '{$tempFilePath}' is not a valid CSV file.");

        $csvFlightRepository = new CsvFlightRepository();
        $flights = $csvFlightRepository->findAll($tempFilePath);

        unlink($tempFilePath);
    }
}
