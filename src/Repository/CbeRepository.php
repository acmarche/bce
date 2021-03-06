<?php

namespace AcMarche\Bce\Repository;

use AcMarche\Bce\Cache\CbeCache;
use AcMarche\Bce\Entity\Enterprise;
use Exception;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class CbeRepository
{
    public function __construct(private ApiCbeRepository $apiCbeRepository, private SerializerInterface $serializer, private CbeCache $cbeCache)
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    public function findByNumber(string $number): Enterprise
    {
        try {
            $cbeJson = $this->apiCbeRepository->getByNumber($number);
            $this->cbeCache->write($cbeJson, $number);

            $entreprise = $this->serializer->deserialize(
                $cbeJson,
                Enterprise::class,
                'json'
            );
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode(), $exception);
        }

        return $entreprise;
    }
}
