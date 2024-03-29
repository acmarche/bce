<?php

namespace AcMarche\Bce\Import;

use AcMarche\Bce\Entity\Code;
use AcMarche\Bce\Repository\CodeRepository;
use AcMarche\Bce\Utils\CsvReader;

class CodeHandler implements ImportHandlerInterface
{
    public function __construct(private readonly CodeRepository $codeRepository, private readonly CsvReader $csvReader)
    {
    }

    public function start(): void
    {
    }

    /**
     * @return Code[]
     *
     * @throws \Exception
     */
    public function readFile(string $fileName): iterable
    {
        return $this->csvReader->readFileAndConvertToClass($fileName);
    }

    /**
     * @param Code $data
     */
    public function handle($data): void
    {
        if (($code = $this->codeRepository->checkExist($data->code, $data->language, $data->category)) instanceof Code) {
            $code->description = $data->description;
        } else {
            $this->codeRepository->persist($data);
        }
    }

    /**
     * @param Code $data
     */
    public function writeLn($data): string
    {
        return $data->code;
    }

    public function flush(): void
    {
        $this->codeRepository->flush();
    }

    public static function getDefaultIndexName(): string
    {
        return 'code';
    }
}
