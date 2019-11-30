<?php

namespace App\API\WeatherAPI;

use App\Entity\City;

interface WeatherInterface{

    public function getWeatherByLongLat(float $longitude, float $latitude):City;

}
