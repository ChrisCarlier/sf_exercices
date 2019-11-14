<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\HourlyWeather;
use App\Entity\Weather;
use App\Interfaces\WeatherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route ("/", name="home")
     * @param WeatherInterface $weatherCH
     * @return Response
     */
    public function index(WeatherInterface $weatherCH){
        $result = $weatherCH->getWeatherByName('Mons');

        // Ville
        $city = new City();
        $city = $weatherCH->getWeatherCity($result);

        return $this->render('pages/home.html.twig',[
            'city' => $city
        ]);
    }

}