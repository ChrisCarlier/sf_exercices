<?php


namespace App\API\WeatherAPI;

use App\API\Normalizer\CityWeatherNormalizer;
use App\Entity\City;
use App\Entity\HourlyWeather;
use App\Entity\Weather;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class weatherCH implements WeatherInterface
{
    protected function getSerializer(): Serializer
    {
        return new Serializer([new CityWeatherNormalizer()]);
    }

    /**
     * @param float $longitude
     * @param float $latitude
     * @return City
     */
    public function getWeatherByLongLat(float $longitude, float $latitude): City
    {
        $client = HttpClient::create(['http_version' => '2.0']);
        try {
            $serializer = $this->getSerializer();
            $response = $client->request('GET', sprintf('https://www.prevision-meteo.ch/services/json/lat=%slng=%s', $latitude,$longitude));
            return $serializer->denormalize($response->toArray(), City::class);
        } catch (ExceptionInterface | DecodingExceptionInterface | ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface | TransportExceptionInterface $e) {
            return null;
        }
    }

}