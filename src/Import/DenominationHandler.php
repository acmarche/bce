<?php

namespace AcMarche\Bce\Import;

use AcMarche\Bce\Entity\Denomination;
use AcMarche\Bce\Repository\DenominationRepository;
use AcMarche\Bce\Utils\CsvReader;

class DenominationHandler implements ImportHandlerInterface
{
    public function __construct(private readonly DenominationRepository $denominationRepository, private readonly CsvReader $csvReader)
    {
    }

    public function start(): void
    {
    }

    /**
     * @throws \Exception
     */
    public function readFile(string $fileName): iterable
    {
        return $this->csvReader->readCSVGenerator($fileName);
    }

    /**
     * @param array $data
     */
    public function handle($data): void
    {
        if ('EntityNumber' === $data[0]) {
            return;
        }

        if (!($denomination = $this->denominationRepository->checkExist($data[0], $data[1], $data[2])) instanceof Denomination) {
            $denomination = new Denomination();
            $denomination->entityNumber = $data[0];
            $denomination->language = $data[1];
            $denomination->typeOfDenomination = $data[2];
            $this->denominationRepository->persist($denomination);
        }

        $this->updateDenomination($denomination, $data);
    }

    /**
     * "EntityNumber","Language","TypeOfDenomination","Denomination".
     */
    private function updateDenomination(Denomination $denomination, array $data): void
    {
        $denomination->denomination = $data[3];
    }

    /**
     * @param Denomination $data
     */
    public function writeLn($data): string
    {
        return $data[0];
    }

    public function flush(): void
    {
        $this->denominationRepository->flush();
    }

    public static function getDefaultIndexName(): string
    {
        return 'denomination';
    }
}
