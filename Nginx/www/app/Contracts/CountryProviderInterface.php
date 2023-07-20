<?php

namespace App\Contracts;

interface CountryProviderInterface
{
    public function isEuropeanCountry(string $countryCode): bool;
}
