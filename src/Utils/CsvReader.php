<?php

namespace AcMarche\Bce\Utils;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\SerializerInterface;

class CsvReader
{
    public function __construct(private readonly ParameterBagInterface $parameterBag, private readonly SerializerInterface $serializer)
    {
    }

    /**
     * @throws \Exception
     */
    public function readFileAndConvertToClass(string $fileName): iterable
    {
        $varDirectory = $this->parameterBag->get('kernel.project_dir').'/var/cbe';
        $file = $varDirectory.'/'.$fileName.'.csv';

        if (!is_readable($file)) {
            throw new \Exception('File not found '.$file);
        }

        $class = 'AcMarche\Bce\Entity\\'.ucfirst($fileName).'[]';
        try {
            $objects = $this->serializer->deserialize(file_get_contents($file), $class, 'csv', [
            ]);
        } catch (\Exception$exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode(), $exception);
        }

        return $objects;
    }

    /**
     * @throws \Exception
     */
    public function readCSVGenerator(string $fileName): iterable
    {
        $varDirectory = $this->parameterBag->get('kernel.project_dir').'/var/cbe';
        $file = $varDirectory.'/'.$fileName.'.csv';

        if (!is_readable($file)) {
            throw new \Exception('File not found '.$file);
        }

        $handle = fopen($file, 'r');

        while (!feof($handle)) {
            yield fgetcsv($handle);
        }

        fclose($handle);
    }
}
