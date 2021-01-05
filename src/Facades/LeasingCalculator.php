<?php

namespace Jorjika\LeasingCalculator\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jorjika\LeasingCalculator\LeasingCalculator
 */
class LeasingCalculator extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'leasing-calculator';
    }
}
