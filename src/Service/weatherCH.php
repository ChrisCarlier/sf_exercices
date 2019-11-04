<?php


namespace App\Service;


use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class weatherCH implements \iWeather
{
    /**
     * @param string $name
     * @return string
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getWeatherByName(string $name){
        $client = HttpClient::create(['http_version' => '2.0']);

        $response = $client->request('GET', 'https://www.prevision-meteo.ch/services/json/'.$name);

        $contents = $response->getContent();

        return $contents;
    }
}
