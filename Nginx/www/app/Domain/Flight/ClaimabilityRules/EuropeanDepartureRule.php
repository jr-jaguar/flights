<?php

namespace App\Domain\Flight\ClaimabilityRules;

use App\Contracts\CountryProviderInterface;
use App\Domain\Flight\Flight;

class EuropeanDepartureRule implements ClaimabilityRuleInterface
{
    private $countryProvider;

    public function __construct(CountryProviderInterface $countryProvider)
    {
        $this->countryProvider = $countryProvider;
    }

    public function isSatisfied(Flight $flight): bool
    {
        return $this->countryProvider->isEuropeanCountry($flight->getCountryCode());
    }
}
