<?php

namespace Jorjika\LeasingCalculator;

use Illuminate\Support\ServiceProvider;
use Jorjika\LeasingCalculator\Commands\LeasingCalculatorCommand;

class LeasingCalculatorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/leasing-calculator.php' => config_path('leasing-calculator.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/leasing-calculator'),
            ], 'views');

            $migrationFileName = 'create_leasing_calculator_table.php';
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                    __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
                ], 'migrations');
            }

            $this->commands([
                LeasingCalculatorCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'leasing-calculator');
    }

    public function register()
    {
        $this->app->bind('leasing-calculator', function ($app) {
            return new LeasingCalculator();
        });

        $this->mergeConfigFrom(__DIR__ . '/../config/leasing-calculator.php', 'leasing-calculator');
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }
}
