<?php


namespace App\Service;


use App\Entity\City;
use App\Entity\HourlyWeather;
use App\Entity\Weather;
use App\Interfaces\WeatherInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class weatherCH implements WeatherInterface
{
    /**
     * @param string $name
     * @param int $day
     * @return array
     */
    public function getWeatherByName(string $name): array
    {

        $client = HttpClient::create(['http_version' => '2.0']);
        try {
            $response = $client->request('GET', sprintf('https://www.prevision-meteo.ch/services/json/%s', $name));

            return $response->toArray();
//            return $response->toArray()[sprintf("fcst_day_%d", $day)];
        } catch (DecodingExceptionInterface | ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface | TransportExceptionInterface $e) {
            return [];
        }
    }

    public function getWeatherCity(array $httpresponse):City
    {
        $city = new City();
        $city->setLatitude($httpresponse['city_info']['latitude']);
        $city->setLongitude($httpresponse['city_info']['longitude']);
        $city->setName($httpresponse['city_info']['name']);
        $city->setHumidite($httpresponse['current_condition']['humidity']);
        $city->setPression($httpresponse['current_condition']['pressure']);

        for ($i=0; $i<4; $i++){
            $result_weather = $httpresponse[sprintf('fcst_day_%d',$i)];
            $weather = new Weather();
            $weather->setCondition($result_weather['condition']);
            $weather->setJour($result_weather['day_long']);
            $weather->setIcon($result_weather['icon']);
            $weather->setTmax($result_weather['tmax']);
            $weather->setTmin($result_weather['tmin']);

            $result_hourly = new HourlyWeather();
            $result_hourly->setHour('12h00');
            $result_hourly->setIcon($result_weather['hourly_data']['12H00']['ICON']);
            $weather->addHourlyData($result_hourly);

            $result_hourly = new HourlyWeather();
            $result_hourly->setHour('18h00');
            $result_hourly->setIcon($result_weather['hourly_data']['18H00']['ICON']);
            $weather->addHourlyData($result_hourly);

            $city->addWeather($weather);
        }
        return $city;
    }
}