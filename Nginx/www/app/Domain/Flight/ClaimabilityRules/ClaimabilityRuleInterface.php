<?php

namespace App\Domain\Flight\ClaimabilityRules;

use App\Domain\Flight\Flight;

interface ClaimabilityRuleInterface
{
    public function isSatisfied(Flight $flight): bool;
}
