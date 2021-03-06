<?php

namespace Jorjika\LeasingCalculator\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Log;

class Auth
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
            'base_uri' => config('leasing-calculator.host'),
        ]);
    }

    public function login()
    {
        $response = json_decode($this->auth());
        session(['leasing_calculator_token' => $response->data->token]);

        return $response->data;
    }

    public function check()
    {
        $token = session('leasing_calculator_token');

        return $token;
    }

    protected function auth()
    {
        try {
            $response = $this->client->request('POST', $this->endpoint, [
                'form_params' => [
                    'email' => $this->user,
                    'password' => $this->password,
                ],
            ]);

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                throw $e;
                Log::error(Message::toString($e->getResponse()));
            }
        }
    }
}
