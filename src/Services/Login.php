<?php

namespace Jorjika\LeasingCalculator\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Message;

class Login
{
    protected $endpoint;
    protected $user;
    protected $password;

    public function __construct()
    {
        $this->endpoint = config('leasing-calculator.login_endpoint');
        $this->user = config('leasing-calculator.user');
        $this->password = config('leasing-calculator.password');
        $this->client = new Client([
            'base_uri' =>  config('leasing-calculator.host')
        ]);
    }

    public function login()
    {
        return json_decode($this->auth());
    }


    protected function auth()
    {
        try {
            $response = $this->client->request('POST', $this->endpoint, [
                'form_params' => [
                    'email' => $this->user,
                    'password' => $this->password
                ]
            ]);
        } catch (RequestException $e) {
            echo Message::toString($e->getRequest());
            if ($e->hasResponse()) {
                echo Message::toString($e->getResponse());
            }
        }
        return $response->getBody()->getContents();
    }
}
