<?php

namespace Jorjika\LeasingCalculator;

use Jorjika\LeasingCalculator\Services\Login;

class LeasingCalculator
{
    public function init()
    {
        $login = new Login();
        $user = $login->login();
        return $user;
    }
}
