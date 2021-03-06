<?php

namespace AcMarche\Bce\Repository;

use AcMarche\Bce\Doctrine\OrmCrudTrait;
use AcMarche\Bce\Entity\Activity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Activity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Activity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Activity[]    findAll()
 * @method Activity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityRepository extends ServiceEntityRepository
{
    use OrmCrudTrait;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Activity::class);
    }

    public function checkExist(int $naceCode, string $entityNumber, string $activityGroup): ?Activity
    {
        return $this->createQueryBuilder('activity')
            ->andWhere('activity.naceCode = :naceCode')
            ->setParameter('naceCode', $naceCode)
            ->andWhere('activity.entityNumber = :entityNumber')
            ->setParameter('entityNumber', $entityNumber)
            ->andWhere('activity.activityGroup = :activityGroup')
            ->setParameter('activityGroup', $activityGroup)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
