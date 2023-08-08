<?php

namespace AcMarche\Bce\Import;

use AcMarche\Bce\Entity\Branch;
use AcMarche\Bce\Repository\BranchRepository;
use AcMarche\Bce\Utils\CsvReader;

class BranchHandler implements ImportHandlerInterface
{
    public function __construct(private readonly BranchRepository $branchRepository, private readonly CsvReader $csvReader)
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
        return $this->csvReader->readFileAndConvertToClass($fileName);
    }

    /**
     * @param Branch $data
     */
    public function handle($data): void
    {
        if (($branch = $this->branchRepository->checkExist($data->id)) instanceof Branch) {
            $branch->startDate = $data->startDate;
            $branch->enterpriseNumber = $data->enterpriseNumber;
        } else {
            $this->branchRepository->persist($data);
        }
    }

    /**
     * @param Branch $data
     */
    public function writeLn($data): string
    {
        return $data->id;
    }

    public function flush(): void
    {
        $this->branchRepository->flush();
    }

    public static function getDefaultIndexName(): string
    {
        return 'branch';
    }
}
