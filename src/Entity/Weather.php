<?php


namespace App\Entity;


use Symfony\Component\Serializer\Annotation\SerializedName;

class Weather
{

    /**
     * @SerializedName("day_long")
     */
    private $jour;

    private $tmin;
    private $tmax;
    private $condition;
    private $icon;
    private $hourly_data;

    /**
     * Weather constructor.
     */
    public function __construct()
    {
        $this->hourly_data = [];
    }

    public function addHourlyData(HourlyWeather $hourlyWeather):void
    {
        array_push($this->hourly_data,$hourlyWeather);
    }

    /**
     * @return mixed
     */
    public function getJour()
    {
        return $this->jour;
    }

    /**
     * @param mixed $jour
     */
    public function setJour($jour): void
    {
        $this->jour = $jour;
    }

    /**
     * @return mixed
     */
    public function getTmin()
    {
        return $this->tmin;
    }

    /**
     * @param mixed $tmin
     */
    public function setTmin($tmin): void
    {
        $this->tmin = $tmin;
    }

    /**
     * @return mixed
     */
    public function getTmax()
    {
        return $this->tmax;
    }

    /**
     * @param mixed $tmax
     */
    public function setTmax($tmax): void
    {
        $this->tmax = $tmax;
    }

    /**
     * @return mixed
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @param mixed $condition
     */
    public function setCondition($condition): void
    {
        $this->condition = $condition;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     */
    public function setIcon($icon): void
    {
        $this->icon = $icon;
    }

    /**
     * @return mixed
     */
    public function getHourlyData()
    {
        return $this->hourly_data;
    }



}