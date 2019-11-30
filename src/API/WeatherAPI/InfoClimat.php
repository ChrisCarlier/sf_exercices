<?php


namespace App\API\WeatherAPI;

use App\API\Normalizer\InfoClimatNormalizer;
use App\Entity\City;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class InfoClimat implements WeatherInterface
{
    protected function getSerializer(): Serializer
    {
        return new Serializer([new InfoClimatNormalizer()]);
    }

    public function getWeatherByLongLat(float $longitude, float $latitude): City
    {
        $client = HttpClient::create(['http_version' => '1.1']);
        try {
            $serializer = $this->getSerializer();
            $response = $client->request('GET', sprintf('http://www.infoclimat.fr/public-api/gfs/json?_ll=%s,%s&_auth=UkgFEgd5UHIFKAM0AHYDKgdvBDFeKAEmVioFZg5rAn8Aa1MyBWVQNgBuVisHKFdhUH1SMQA7V2cKYQR8CHpRMFI4BWkHbFA3BWoDZgAvAygHKQRlXn4BJlY0BWIOagJ%%2FAGtTPgV4UDMAZlY0BylXYlBhUjAAIFdwCmgEZghiUTdSMQVkB2xQOgVpA2YALwMoBzEEMF40AThWMgU2DmoCZABlUzYFNVA3AGtWMgcpV2ZQYFI1ADtXbQphBGIIYVEtUi4FGAcXUC8FKgMjAGUDcQcpBDFePwFt&_c=f280f1a318bd21b9bbdf04a1b87aaeb8'
                , $latitude,$longitude));
            return $serializer->denormalize($response->toArray(), City::class);
        } catch (ExceptionInterface | DecodingExceptionInterface | ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface | TransportExceptionInterface $e) {
            return null;
        }
    }
}