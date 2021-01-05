<?php

namespace Jorjika\LeasingCalculator;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jorjika\LeasingCalculator\LeasingCalculator
 */
class LeasingCalculatorFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'leasing-calculator';
    }
}
