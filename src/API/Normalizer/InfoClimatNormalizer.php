<?php


namespace App\API\Normalizer;


use App\Entity\City;
use App\Entity\Weather;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;

class InfoClimatNormalizer implements ContextAwareDenormalizerInterface
{

    /**
     * {@inheritdoc}
     *
     * @param array $context options that denormalizers have access to
     */
    public function supportsDenormalization($data, $type, $format = null, array $context = [])
    {
        if ($type!== City::class)
            return false;

        if(!isset($data['message']))
            return false;

        if($data['message'] != 'OK')
            return false;

        return true;
    }

    /**
     * Denormalizes data back into an object of the given class.
     *
     * @param mixed $data Data to restore
     * @param string $type The expected class to instantiate
     * @param string $format Format the given data was extracted from
     * @param array $context Options available to the denormalizer
     *
     * @return object|array
     *
     * @throws BadMethodCallException   Occurs when the normalizer is not called in an expected context
     * @throws InvalidArgumentException Occurs when the arguments are not coherent or not supported
     * @throws UnexpectedValueException Occurs when the item cannot be hydrated with the given data
     * @throws ExtraAttributesException Occurs when the item doesn't have attribute to receive given data
     * @throws LogicException           Occurs when the normalizer is not supposed to denormalize
     * @throws RuntimeException         Occurs if the class cannot be instantiated
     */
    public function denormalize($data, $type, $format = null, array $context = [])
    {
        setlocale(LC_ALL, "fr_FR");
        $timeReference = '16:00:00';
        $dateReference = date('o-m-d',time());

        $city = new City();
        $city->setLongitude('?');
        $city->setLatitude('?');
        $city->setName('Info Climat');
        $city->setHumidite($data[$dateReference.' '.$timeReference]['humidite']['2m']);
        $city->setPression($data[$dateReference.' '.$timeReference]['pression']['niveau_de_la_mer'] / 100);

        for($i=0;$i<5;$i++)
        {
            $current_date = date('o-m-d', strtotime($dateReference . ' +'.$i.' day')) . ' ' . $timeReference;
            $weather = new Weather();
            $weather->setTmax($data[$current_date]['temperature']['2m']);
            $weather->setTmin($data[$current_date]['temperature']['2m']);
            $weather->setJour(strftime("%A",  strtotime($dateReference . ' +'.$i.' day')));
//            $weather->setCondition('?');
            $city->addWeather($weather);
        }

        return $city;
    }

}