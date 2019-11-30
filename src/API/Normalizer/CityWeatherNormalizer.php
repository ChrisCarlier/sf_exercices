<?php


namespace App\API\Normalizer;


use App\Entity\City;
use App\Entity\Weather;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;

class CityWeatherNormalizer implements ContextAwareDenormalizerInterface
{

//    public function convertJsonToCity(array $cityResponse)
//    {
//        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
//
//        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory);
//
//        $serializer = new Serializer(
//            [new ObjectNormalizer($classMetadataFactory, $metadataAwareNameConverter)],
//            ['json' => new JsonEncoder()]
//        );
//
//        /** @var City $city */
//        $city = $serializer->deserialize(json_encode($cityResponse['city_info']),City::class ,'json');
//
//        /** @var Weather $weather */
//        $weather = $serializer->deserialize(json_encode($cityResponse['fcst_day_0']),Weather::class ,'json');
////        dump($cityResponse);
//        $city->setPression($cityResponse['current_condition']['pressure']);
//        $city->setHumidite($cityResponse['current_condition']['humidity']);
//        $city->addWeather($weather);
////        dump($city);
//
//        return $city;
//    }

    /**
     * {@inheritdoc}
     *
     * @param array $context options that denormalizers have access to
     */
    public function supportsDenormalization($data, $type, $format = null, array $context = [])
    {
        if ($type!== City::class)
            return false;

        if(!isset($data['city_info']))
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
        $city = new City();
        $city->setLongitude($data['city_info']['longitude']);
        $city->setLatitude($data['city_info']['latitude']);
        $city->setName($data['city_info']['name']);
        $city->setHumidite($data['current_condition']['humidity']);
        $city->setPression($data['current_condition']['pressure']);

        for($d = 0; $d < 5 ; $d++)
        {
            $day = sprintf('fcst_day_%d',$d);
            $weather = new Weather();
            $weather->setIcon($data[$day]['icon']);
            $weather->setTmax($data[$day]['tmax']);
            $weather->setTmin($data[$day]['tmin']);
            $weather->setJour($data[$day]['day_long']);
            $weather->setCondition($data[$day]['condition']);

            $city->addWeather($weather);
        }

        return $city;
    }
}