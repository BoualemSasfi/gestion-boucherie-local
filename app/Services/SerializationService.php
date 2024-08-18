<?php


namespace App\Services;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class SerializationService
{
    protected $serializer;

    public function __construct()
    {
        // Configurer les normalizers et les encoders
        $normalizers = [new ObjectNormalizer()];
        $encoders = [new JsonEncoder()];

        // Initialiser le serializer avec les normalizers et encoders
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * Sérialiser un objet en JSON.
     *
     * @param mixed $data
     * @return string
     */
    public function serializeToJson($data)
    {
        return $this->serializer->serialize($data, 'json');
    }

    /**
     * Désérialiser une chaîne JSON en un objet de classe.
     *
     * @param string $json
     * @param string $type
     * @return mixed
     */
    public function deserializeFromJson($json, $type)
    {
        return $this->serializer->deserialize($json, $type, 'json');
    }
}
