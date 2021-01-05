<?php

namespace Jorjika\LeasingCalculator\Commands;

use Illuminate\Console\Command;

class LeasingCalculatorCommand extends Command
{
    public $signature = 'leasing-calculator';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
