<?php


namespace App\Service;


use App\Interfaces\WeatherInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class weatherCH implements WeatherInterface
{
    /**
     * @param string $name
     * @param int $day
     * @return string
     */
    public function getWeatherByName(string $name,int $day):string
    {
        $client = HttpClient::create(['http_version' => '2.0']);
        try {
            $response = $client->request('GET', sprintf('https://www.prevision-meteo.ch/services/json/%s', $name));
            $contents = $response->getContent();
            $tomorrow = json_decode($contents);
            return json_encode($tomorrow->fcst_day_1);
        } catch (ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface | TransportExceptionInterface $e) {
            return "";
        }
    }
}