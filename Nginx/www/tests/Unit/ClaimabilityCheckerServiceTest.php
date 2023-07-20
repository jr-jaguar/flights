<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Domain\Services\ClaimabilityCheckerService;
use App\Contracts\CountryProviderInterface;
use App\Domain\Flight\Flight;
use App\Domain\Flight\ClaimabilityRules\ClaimabilityRuleInterface;

class ClaimabilityCheckerServiceTest extends TestCase
{
    public function testIsClaimableReturnsTrueForEligibleFlight()
    {
        $countryProviderMock = $this->createMock(CountryProviderInterface::class);
        $countryProviderMock->method('isEuropeanCountry')->willReturn(true);

        $claimabilityRuleMock = $this->createMock(ClaimabilityRuleInterface::class);
        $claimabilityRuleMock->method('isSatisfied')->willReturn(true);

        $flight = new Flight('LV', 'Delay', 3);
        $claimabilityChecker = new ClaimabilityCheckerService($countryProviderMock, [$claimabilityRuleMock]);

        $result = $claimabilityChecker->isClaimable($flight);

        $this->assertTrue($result);
    }

    public function testIsClaimableReturnsFalseForNonEuropeanCountry()
    {
        $countryProviderMock = $this->createMock(CountryProviderInterface::class);
        $countryProviderMock->method('isEuropeanCountry')->willReturn(false);

        $claimabilityRuleMock = $this->createMock(ClaimabilityRuleInterface::class);
        $claimabilityRuleMock->method('isSatisfied')->willReturn(true);

        $flight = new Flight('US', 'Cancel', 10);
        $claimabilityChecker = new ClaimabilityCheckerService($countryProviderMock, [$claimabilityRuleMock]);

        $result = $claimabilityChecker->isClaimable($flight);

        $this->assertFalse($result);
    }

    public function testIsClaimableReturnsFalseIfAnyRuleNotSatisfied()
    {
        $countryProviderMock = $this->createMock(CountryProviderInterface::class);
        $countryProviderMock->method('isEuropeanCountry')->willReturn(true);

        $rule1Mock = $this->createMock(ClaimabilityRuleInterface::class);
        $rule1Mock->method('isSatisfied')->willReturn(true);

        $rule2Mock = $this->createMock(ClaimabilityRuleInterface::class);
        $rule2Mock->method('isSatisfied')->willReturn(false); // Not satisfied

        $flight = new Flight('LV', 'Delay', 3);
        $claimabilityChecker = new ClaimabilityCheckerService($countryProviderMock, [$rule1Mock, $rule2Mock]);

        $result = $claimabilityChecker->isClaimable($flight);

        $this->assertFalse($result);
    }
}
