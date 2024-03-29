<?php

namespace AcMarche\Bce\Cache;

use AcMarche\Bce\Entity\Enterprise;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\SerializerInterface;

class CbeCache
{
    public function __construct(private readonly ParameterBagInterface $parameterBag, private readonly SerializerInterface $serializer)
    {
    }

    public function getCacheData(string $number): ?Enterprise
    {
        $varDirectory = $this->parameterBag->get('kernel.project_dir').'/var/cbe';
        $file = $varDirectory.'/'.$number.'.json';

        if (is_readable($file)) {
            $cbeJson = file_get_contents($file);

            return $this->serializer->deserialize(
                $cbeJson,
                Enterprise::class,
                'json'
            );
        }

        return null;
    }

    public function write(string $cbeJson, string $number): void
    {
        $file = $this->getVarDirectory().'/'.$number.'.json';
        $filesystem = new Filesystem();
        $filesystem->dumpFile($file, $cbeJson);
    }

    private function getVarDirectory(): string
    {
        return $this->parameterBag->get('kernel.project_dir').'/var/cbe';
    }
}
