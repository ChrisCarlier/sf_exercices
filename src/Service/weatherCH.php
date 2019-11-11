<?php


namespace App\Service;


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
    public function getWeatherByName(string $name,int $day): array
    {
        $client = HttpClient::create(['http_version' => '2.0']);
        try {
            $response = $client->request('GET', sprintf('https://www.prevision-meteo.ch/services/json/%s', $name));
            return $response->toArray()[sprintf("fcst_day_%d", $day)];
        } catch (DecodingExceptionInterface | ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface | TransportExceptionInterface $e) {
            return [];
        }
    }
}