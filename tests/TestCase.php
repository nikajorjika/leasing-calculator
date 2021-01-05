<?php

namespace Jorjika\LeasingCalculator\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Jorjika\LeasingCalculator\LeasingCalculatorServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Jorjika\\LeasingCalculator\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LeasingCalculatorServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        /*
        include_once __DIR__.'/../database/migrations/create_leasing_calculator_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }
}
