<?php

namespace AcMarche\Bce\Entity;

use AcMarche\Bce\Repository\EnterpriseRepository;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity(fields: ['enterpriseNumber'])]
#[ORM\Entity(repositoryClass: EnterpriseRepository::class)]
#[ORM\Table(name: 'bce_enterprise')]
#[ORM\UniqueConstraint(name: 'enterprise_idx', columns: ['enterprise_number'])]
class Enterprise implements Stringable
{
    use IdTrait;
    #[ORM\Column(type: 'string', length: 50, nullable: false, unique: true)]
    public string $enterpriseNumber;
    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    public string $status;
    #[ORM\Column(type: 'smallint', length: 5, nullable: false)]
    public int $juridicalSituation;
    #[ORM\Column(type: 'smallint', length: 5, nullable: false)]
    public int $typeOfEnterprise;
    #[ORM\Column(type: 'smallint', length: 5, nullable: false)]
    public int $juridicalForm;
    #[ORM\Column(type: 'string', length: 20, nullable: false)]
    public string $startDate;
    /**
     * @var array|Activity[]
     */
    public array $activities;
    /**
     * @var array|Establishment[]
     */
    public array $establishments;
    /**
     * @var array|Denomination[]
     */
    public array $denominations;
    /**
     * @var array|Contact[]
     */
    public array $contacts;
    /**
     * @var array|Address[]
     */
    public array $addresses;
    /**
     * @var array ['fr'=>'']
     */
    public array $statusDescription;
    public array $juridicalSituationDescription;
    public array $typeOfEnterpriseDescription;
    public array $juridicalFormDescription;

    public function __toString(): string
    {
        return $this->enterpriseNumber;
    }
}
