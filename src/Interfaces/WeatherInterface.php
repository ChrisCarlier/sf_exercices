<?php

namespace App\Interfaces;

use App\Entity\City;

interface WeatherInterface{

    public function getWeatherByName(string $name):City;
    public function getWeatherCity(array $httpresponse):City;

}
