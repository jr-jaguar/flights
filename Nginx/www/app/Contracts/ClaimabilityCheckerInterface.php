<?php

namespace App\Contracts;

use App\Domain\Flight\Flight;

interface ClaimabilityCheckerInterface
{
    public function isClaimable(Flight $flight): bool;
}
