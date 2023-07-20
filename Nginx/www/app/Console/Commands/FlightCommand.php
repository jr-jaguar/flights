<?php

namespace App\Console\Commands;

use App\Contracts\ClaimabilityCheckerInterface;
use App\Contracts\FlightRepositoryInterface;
use Illuminate\Console\Command;

class FlightCommand extends Command
{
    protected $signature = 'flight:check:claimable {file}';
    protected $description = 'Check flight claimability based on decision table';

    private $claimabilityChecker;
    private $flightRepository;

    public function __construct(ClaimabilityCheckerInterface $claimabilityChecker, FlightRepositoryInterface $flightRepository)
    {
        parent::__construct();
        $this->claimabilityChecker = $claimabilityChecker;
        $this->flightRepository = $flightRepository;
    }

    public function handle()
    {
        $filePath = $this->argument('file');

        try {
            $flights = $this->flightRepository->findAll($filePath);

            $headers = ['Country', 'Status', 'Status Details', 'Claimable'];
            $rows = [];

            foreach ($flights as $flight) {
                $claimable = $this->claimabilityChecker->isClaimable($flight) ? 'Y' : 'N';
                $rows[] = [
                    $flight->getCountryCode(),
                    $flight->getStatus(),
                    $flight->getStatusDetails(),
                    $claimable
                ];
            }

            $this->table($headers, $rows);
        } catch (\Exception $e) {
            $this->error("Error: {$e->getMessage()}");
            return 1;
        }
    }
}
