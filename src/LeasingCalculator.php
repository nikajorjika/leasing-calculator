<?php

namespace Jorjika\LeasingCalculator;

use GuzzleHttp\Client;
use Jorjika\LeasingCalculator\Services\Auth;

class LeasingCalculator
{
    protected $auth;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('leasing-calculator.host'),
        ]);
        $this->auth = new Auth();
        if (!$this->auth->check()) {
            $this->auth->login();
        }
    }

    public function getConditions($car, $amount = null, $downpayment = null, $currency = 'USD')
    {
        if (!$car) {
            $query = [
                'amount' => $amount,
                'down_payment_amount' => $downpayment,
                'ccy' => $currency
            ];
        } else {
            $query = [
                'remote_car_id' => $car->id,
            ];
        }
        $response = $this->client->request('GET', config('leasing-calculator.terms_endpoint'), [
            'query' => $query,
            'headers' =>
            [
                'Authorization' => "Bearer " . $this->auth->check(),
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            abort($response->getStatusCode(), $response->getBody()->getContents());
        }

        return json_decode($response->getBody()->getContents());
    }

    public function addCar($car)
    {
        $response = $this->client->request('POST', config('leasing-calculator.new_car_endpoint'), [
            'form_params' => $car,
            'headers' => [
                'Authorization' => "Bearer " . $this->auth->check(),
            ],
        ]);
        if ($response->getStatusCode() !== 200) {
            abort($response->getStatusCode(), $response->getBody()->getContents());
        }

        return json_decode($response->getBody()->getContents());
    }

    public function addCars($cars)
    {
        $formParams = self::normalizeCarsArray($cars);
        $response = $this->client->request('POST', config('leasing-calculator.new_cars_endpoint'), [
            'form_params' => $formParams,
            'headers' => [
                'Authorization' => "Bearer " . $this->auth->check(),
            ],
        ]);
        if ($response->getStatusCode() !== 200) {
            abort($response->getStatusCode(), $response->getBody()->getContents());
        }

        return json_decode($response->getBody()->getContents());
    }

    public function normalizeCarsArray($cars)
    {
        $result = [];
        foreach ($cars as $key => $car) {
            $keyStart = "data[$key]";
            $result[$keyStart . "['name']"] = $car['name'];
            $result[$keyStart . "['link']"] = $car['link'];
            $result[$keyStart . "['price']"] = $car['price'];
            $result[$keyStart . "['remote_car_id']"] = $car['remote_car_id'];
            $result[$keyStart . "['year']"] = $car['year'];
            $result[$keyStart . "['sold']"] = $car['sold'];
        }

        return $result;
    }
}
