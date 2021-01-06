<?php

namespace Jorjika\LeasingCalculator;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Log;
use Jorjika\LeasingCalculator\Services\Auth;

class LeasingCalculator
{
    protected $auth;
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' =>  config('leasing-calculator.host')
        ]);
        $this->auth = new Auth();
        if (!$this->auth->check()) {
            $this->auth->login();
        }
    }

    public function init($car)
    {
        return $this->getConditions($car);
    }

    public function getConditions($car)
    {
        $response = $this->client->request('GET', config('leasing-calculator.terms_endpoint'), [
            'query' => [
                'remote_car_id' => $car->id
            ],
            'headers' =>
            [
                'Authorization' => "Bearer " . $this->auth->check()
            ]
        ]);
        dd($response->getBody()->getContents());
        return $response->getBody()->getContents();
    }
}
