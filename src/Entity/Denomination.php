<?php

namespace AcMarche\Bce\Entity;

use AcMarche\Bce\Repository\DenominationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity(fields: ['entityNumber', 'language', 'typeOfDenomination'])]
#[ORM\Entity(repositoryClass: DenominationRepository::class)]
#[ORM\Table(name: 'bce_denomination')]
#[ORM\UniqueConstraint(name: 'denomination_idx', columns: ['entity_number', 'language', 'type_of_denomination'])]
class Denomination implements \Stringable
{
    use IdTrait;
    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    public string $entityNumber;

    #[ORM\Column(type: 'smallint', length: 10, nullable: false)]
    public int $language;

    #[ORM\Column(type: 'smallint', length: 10, nullable: false)]
    public int $typeOfDenomination;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    public string $denomination;

    public function __toString(): string
    {
        return $this->denomination;
    }
}
