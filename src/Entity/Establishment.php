<?php

namespace AcMarche\Bce\Entity;

use AcMarche\Bce\Entity\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use AcMarche\Bce\Repository\EstablishmentRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=EstablishmentRepository::class)
 * @ORM\Table(name="bce_establishment", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="establishment_idx", columns={"establishment_number"})})
 * @UniqueEntity(fields={"establishmentNumber"})
 */
class Establishment
{
    use IdTrait;

    /**
     * @ORM\Column(type="string", length=50, nullable=false, unique=true)
     */
    public string $establishmentNumber;
    /**
     * @ORM\Column(type="string", length=10, nullable=false)
     */
    public string $startDate;
    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    public string $enterpriseNumber;
    /**
     * @var array|Address[]
     */
    public array $addresses;
    /**
     * @var array|Contact[]
     */
    public array $contacts;
    /**
     * @var array|Activity[]
     */
    public array $activities;
    /**
     * @var array|Denomination[]
     */
    public array $denominations;

    public function __toString()
    {
        return $this->establishmentNumber;
    }
}
