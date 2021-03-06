<?php

namespace AcMarche\Bce\Repository;

use AcMarche\Bce\Doctrine\OrmCrudTrait;
use AcMarche\Bce\Entity\Denomination;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Denomination|null find($id, $lockMode = null, $lockVersion = null)
 * @method Denomination|null findOneBy(array $criteria, array $orderBy = null)
 * @method Denomination[]    findAll()
 * @method Denomination[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DenominationRepository extends ServiceEntityRepository
{
    use OrmCrudTrait;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Denomination::class);
    }

    public function checkExist(string $entityNumber, int $language, int $typeOfDenomination): ?Denomination
    {
        return $this->createQueryBuilder('denomination')
            ->andWhere('denomination.entityNumber = :entityNumber')
            ->setParameter('entityNumber', $entityNumber)
            ->andWhere('denomination.typeOfDenomination = :typeOfDenomination')
            ->setParameter('typeOfDenomination', $typeOfDenomination)
            ->andWhere('denomination.language = :language')
            ->setParameter('language', $language)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
