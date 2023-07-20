<?php

namespace App\Domain\Flight\ClaimabilityRules;

use App\Domain\Flight\Flight;

class CancelledWithin14DaysRule implements ClaimabilityRuleInterface
{
    public function isSatisfied(Flight $flight): bool
    {
        return $flight->getStatus() !== 'Cancel' || $flight->getStatusDetails() <= 14;
    }
}
