<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Domain\Services\CountryProvider;

class CountryProviderTest extends TestCase
{
    public function testIsEuropeanCountryReturnsTrueForEuropeanCountry()
    {
        $europeanCountryProvider = new CountryProvider();
        $this->assertTrue($europeanCountryProvider->isEuropeanCountry('FR'));
    }

    public function testIsEuropeanCountryReturnsFalseForNonEuropeanCountry()
    {
        $europeanCountryProvider = new CountryProvider();
        $this->assertFalse($europeanCountryProvider->isEuropeanCountry('US'));
    }
}
