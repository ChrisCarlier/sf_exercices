<?php

namespace App\Controller;

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
        $result = $weatherCH->getWeatherByName('Mons',1);

        return $this->render('pages/home.html.twig',[
            'response' => $result
        ]);
    }

}