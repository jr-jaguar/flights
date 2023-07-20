<?php

namespace App\Domain\Flight\ClaimabilityRules;

use App\Domain\Flight\Flight;

class DepartureDelayMoreThan3HoursRule implements ClaimabilityRuleInterface
{
    public function isSatisfied(Flight $flight): bool
    {
        return $flight->getStatus() !== 'Delay' || $flight->getStatusDetails() >= 3;
    }
}
