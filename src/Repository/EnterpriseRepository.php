<?php

namespace AcMarche\Bce\Repository;

use AcMarche\Bce\Doctrine\OrmCrudTrait;
use AcMarche\Bce\Entity\Enterprise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Enterprise|null find($id, $lockMode = null, $lockVersion = null)
 * @method Enterprise|null findOneBy(array $criteria, array $orderBy = null)
 * @method Enterprise[]    findAll()
 * @method Enterprise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnterpriseRepository extends ServiceEntityRepository
{
    use OrmCrudTrait;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Enterprise::class);
    }

    public function checkExist(string $enterpriseNumber): ?Enterprise
    {
        return $this->createQueryBuilder('enterprise')
            ->andWhere('enterprise.enterpriseNumber = :enterpriseNumber')
            ->setParameter('enterpriseNumber', $enterpriseNumber)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
