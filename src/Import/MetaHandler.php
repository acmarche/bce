<?php

namespace AcMarche\Bce\Import;

use AcMarche\Bce\Entity\Meta;
use AcMarche\Bce\Repository\MetaRepository;
use AcMarche\Bce\Utils\CsvReader;
use Exception;

class MetaHandler implements ImportHandlerInterface
{
    public function __construct(private readonly MetaRepository $metaRepository, private readonly CsvReader $csvReader)
    {
    }

    public function start(): void
    {
    }

    /**
     * @return Meta[]
     *
     * @throws Exception
     */
    public function readFile(string $fileName): iterable
    {
        return $this->csvReader->readFileAndConvertToClass($fileName);
    }

    /**
     * @param Meta $data
     */
    public function handle($data): void
    {
        if (($meta = $this->metaRepository->findByVariable($data->variable)) instanceof Meta) {
            $meta->value = $data->value;
        } else {
            $this->metaRepository->persist($data);
        }
    }

    /**
     * @param Meta $data
     */
    public function writeLn($data): string
    {
        return $data->variable;
    }

    public function flush(): void
    {
        $this->metaRepository->flush();
    }

    public static function getDefaultIndexName(): string
    {
        return 'meta';
    }
}
