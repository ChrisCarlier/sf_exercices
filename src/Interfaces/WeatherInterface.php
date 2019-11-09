<?php

namespace App\Interfaces;


interface WeatherInterface{

    public function getWeatherByName(string $name,int $day):string;

}
