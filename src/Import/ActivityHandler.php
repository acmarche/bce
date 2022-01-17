<?php

namespace AcMarche\Bce\Import;

use AcMarche\Bce\Entity\Activity;
use AcMarche\Bce\Repository\ActivityRepository;
use AcMarche\Bce\Utils\CsvReader;
use Exception;

class ActivityHandler implements ImportHandlerInterface
{
    public function __construct(private ActivityRepository $activityRepository, private CsvReader $csvReader)
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
        if (($activity = $this->activityRepository->checkExist($data[3], $data[0], $data[1])) === null) {
            $activity = new Activity();
            $activity->entityNumber = $data[0];
            $activity->activityGroup = $data[1];
            $activity->naceCode = $data[3];
            $this->activityRepository->persist($activity);
        }
        $this->updateActivity($activity, $data);
    }

    /**
     * "EntityNumber","ActivityGroup","NaceVersion","NaceCode","Classification".
     */
    private function updateActivity(Activity $activity, array $data): void
    {
        $activity->classification = $data[4];
        $activity->naceVersion = $data[2];
    }

    /**
     * @param Activity $data
     */
    public function writeLn($data): string
    {
        return $data[0];
    }

    public function flush(): void
    {
        $this->activityRepository->flush();
    }

    public static function getDefaultIndexName(): string
    {
        return 'activity';
    }
}
