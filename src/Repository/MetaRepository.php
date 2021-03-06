<?php

namespace AcMarche\Bce\Repository;

use AcMarche\Bce\Doctrine\OrmCrudTrait;
use AcMarche\Bce\Entity\Meta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Meta|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meta|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meta[]    findAll()
 * @method Meta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MetaRepository extends ServiceEntityRepository
{
    use OrmCrudTrait;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Meta::class);
    }

    public function findByVariable(string $variable): ?Meta
    {
        return $this->createQueryBuilder('meta')
            ->andWhere('meta.variable = :variable')
            ->setParameter('variable', $variable)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
