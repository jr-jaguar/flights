<?php

namespace App\Domain\Services;

use App\Contracts\ClaimabilityCheckerInterface;
use App\Contracts\CountryProviderInterface;
use App\Domain\Flight\Flight;

class ClaimabilityCheckerService implements ClaimabilityCheckerInterface
{
    private $countryProvider;
    private $claimabilityRules;

    public function __construct(CountryProviderInterface $countryProvider, array $claimabilityRules)
    {
        $this->countryProvider = $countryProvider;
        $this->claimabilityRules = $claimabilityRules;
    }

    public function isClaimable(Flight $flight): bool
    {
        $isEuropeanCountry = $this->countryProvider->isEuropeanCountry($flight->getCountryCode());

        if (!$isEuropeanCountry) {
            return false;
        }

        foreach ($this->claimabilityRules as $rule) {
            if (!$rule->isSatisfied($flight)) {
                return false;
            }
        }

        return true;
    }
}
