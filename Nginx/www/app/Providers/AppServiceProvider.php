<?php

namespace App\Providers;

use App\Contracts\ClaimabilityCheckerInterface;
use App\Contracts\CountryProviderInterface;
use App\Contracts\FlightRepositoryInterface;
use App\Domain\Flight\ClaimabilityRules\CancelledWithin14DaysRule;
use App\Domain\Flight\ClaimabilityRules\DepartureDelayMoreThan3HoursRule;
use App\Domain\Flight\ClaimabilityRules\EuropeanDepartureRule;
use App\Domain\Services\ClaimabilityCheckerService;
use App\Domain\Services\CountryProvider;
use App\Domain\Repositories\CsvFlightRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FlightRepositoryInterface::class, CsvFlightRepository::class);
        $this->app->bind(CountryProviderInterface::class, CountryProvider::class);

        $this->app->bind(ClaimabilityCheckerInterface::class, function ($app) {
            $repository = $app->make(FlightRepositoryInterface::class);
            $countryProvider = $app->make(CountryProviderInterface::class);
            $rules = [
                new EuropeanDepartureRule($countryProvider),
                new CancelledWithin14DaysRule(),
                new DepartureDelayMoreThan3HoursRule()
            ];
            return new ClaimabilityCheckerService($countryProvider, $rules);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
