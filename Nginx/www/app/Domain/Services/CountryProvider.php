<?php

namespace App\Domain\Services;

use App\Contracts\CountryProviderInterface;

class CountryProvider implements CountryProviderInterface
{
    private $europeanCountries = ['EU', 'LT', 'LV', 'EE', 'DE', 'FR', 'IT', 'ES', 'PT', 'PL', 'GR', 'AT', 'BE', 'NL', 'LU', 'SI', 'MT', 'CY', 'SK', 'HU', 'CZ', 'HR', 'BG', 'RO', 'SE', 'FI', 'DK', 'IE'];

    public function isEuropeanCountry(string $countryCode): bool
    {
        return in_array($countryCode, $this->europeanCountries);
    }
}
