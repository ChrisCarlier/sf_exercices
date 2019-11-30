<?php

namespace App\Controller;

use App\Entity\City;
use App\API\WeatherAPI\WeatherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route ("/", name="home")
     * @param WeatherInterface $weatherCH
     * @param WeatherInterface $infoClimat
     * @return Response
     */
    public function index(WeatherInterface $weatherCH,WeatherInterface $infoClimat)
    {
        // Ville
        $city = new City();
        $city_infoClimat = new City();

        $city = $weatherCH->getWeatherByLongLat(8.54,45.32);

        $city_infoClimat = $infoClimat->getWeatherByLongLat(8.54,45.32);

        dump($city_infoClimat);
        return $this->render('pages/home.html.twig',[
            'city' => $city,
            'city_infoClimat' => $city_infoClimat
        ]);
    }

}