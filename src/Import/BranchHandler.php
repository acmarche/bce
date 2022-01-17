<?php

namespace AcMarche\Bce\Import;

use AcMarche\Bce\Entity\Branch;
use AcMarche\Bce\Repository\BranchRepository;
use AcMarche\Bce\Utils\CsvReader;
use Exception;

class BranchHandler implements ImportHandlerInterface
{
    public function __construct(private BranchRepository $branchRepository, private CsvReader $csvReader)
    {
    }

    public function start(): void
    {
    }

    /**
     * @throws Exception
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
        if (($branch = $this->branchRepository->checkExist($data->id)) !== null) {
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
