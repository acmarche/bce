<?php

namespace AcMarche\Bce\Import;

use AcMarche\Bce\Entity\Establishment;
use AcMarche\Bce\Repository\EstablishmentRepository;
use AcMarche\Bce\Utils\CsvReader;

class EstablishmentHandler implements ImportHandlerInterface
{
    public function __construct(private readonly EstablishmentRepository $establishmentRepository, private readonly CsvReader $csvReader)
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
        if ('EstablishmentNumber' === $data[0]) {
            return;
        }

        if (!($establishment = $this->establishmentRepository->checkExist($data[0])) instanceof Establishment) {
            $establishment = new Establishment();
            $establishment->establishmentNumber = $data[0];
            $this->establishmentRepository->persist($establishment);
        }

        $this->updateEstablishment($establishment, $data);
    }

    /**
     * "EstablishmentNumber","StartDate","EnterpriseNumber".
     */
    private function updateEstablishment(Establishment $establishment, array $data): void
    {
        $establishment->startDate = $data[1];
        $establishment->enterpriseNumber = $data[2];
    }

    /**
     * @param array $data
     */
    public function writeLn($data): string
    {
        return $data[0];
    }

    public function flush(): void
    {
        $this->establishmentRepository->flush();
    }

    public static function getDefaultIndexName(): string
    {
        return 'establishment';
    }
}
