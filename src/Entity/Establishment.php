<?php

namespace AcMarche\Bce\Entity;

use AcMarche\Bce\Repository\EstablishmentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity(fields: ['establishmentNumber'])]
#[ORM\Entity(repositoryClass: EstablishmentRepository::class)]
#[ORM\Table(name: 'bce_establishment')]
#[ORM\UniqueConstraint(name: 'establishment_idx', columns: ['establishment_number'])]
class Establishment implements \Stringable
{
    use IdTrait;
    #[ORM\Column(type: 'string', length: 50, nullable: false, unique: true)]
    public string $establishmentNumber;

    #[ORM\Column(type: 'string', length: 10, nullable: false)]
    public string $startDate;

    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    public string $enterpriseNumber;

    /**
     * @var array|Address[]
     */
    public array $addresses = [];

    /**
     * @var array|Contact[]
     */
    public array $contacts = [];

    /**
     * @var array|Activity[]
     */
    public array $activities = [];

    /**
     * @var array|Denomination[]
     */
    public array $denominations = [];

    public function __toString(): string
    {
        return $this->establishmentNumber;
    }
}
