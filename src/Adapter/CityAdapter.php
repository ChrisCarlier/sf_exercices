<?php


namespace App\Adapter;


use App\Entity\City;
use App\Entity\Weather;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CityAdapter
{

    public function convertJsonToCity(array $cityResponse)
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory);

        $serializer = new Serializer(
            [new ObjectNormalizer($classMetadataFactory, $metadataAwareNameConverter)],
            ['json' => new JsonEncoder()]
        );

        $city = $serializer->deserialize(json_encode($cityResponse['city_info']),City::class ,'json');
        $weather = $serializer->deserialize(json_encode($cityResponse['fcst_day_0']),Weather::class ,'json');
        dump($cityResponse);
        dump($weather);
        dump($city);

        return $city;
    }
}