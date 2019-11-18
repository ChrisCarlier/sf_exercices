<?php


namespace App\Entity;


use Symfony\Component\Serializer\Annotation\SerializedName;

class City
{
    private $longitude;
    private $latitude;
    private $name;
    private $weather;
    /**
     * @SerializedName("pressure")
     */
    private $pression;
    /**
     * @SerializedName("humidity")
     */

    private $humidite;

    /**
     * City constructor.
     */
    public function __construct()
    {
        $this->weather = [];
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getWeather()
    {
        return $this->weather;
    }

    /**
     * @param Weather $weather
     */
    public function addWeather(Weather $weather): void {
        array_push($this->weather,$weather);
    }

    /**
     * @return mixed
     */
    public function getPression()
    {
        return $this->pression;
    }

    /**
     * @param mixed $pression
     */
    public function setPression($pression): void
    {
        $this->pression = $pression;
    }

    /**
     * @return mixed
     */
    public function getHumidite()
    {
        return $this->humidite;
    }

    /**
     * @param mixed $humidite
     */
    public function setHumidite($humidite): void
    {
        $this->humidite = $humidite;
    }

}