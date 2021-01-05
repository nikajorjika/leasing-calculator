<?php

return [
    'host' => env('LEASING_HOST', 'http://104.248.36.97'),
    'user' => env('LEASING_USER', 'carfest@dealer'),
    'password' => env('LEASING_PASSWORD', 'carfest'),
    'login_endpoint' => env('LEASING_LOGIN_ENDPOINT', '/api/login'),
    'terms_endpoint' => env('LEASING_TERMS_ENDPOINT', '/api/leasing-terms'),
    'new_car_endpoint' => env('LEASING_LOGIN_ENDPOINT', '/api/car/store'),
    'new_cars_endpoint' => env('LEASING_LOGIN_ENDPOINT', '/api/car/store-many'),
    'new_application_endpoint' => env('LEASING_LOGIN_ENDPOINT', '/api/application'),
];
