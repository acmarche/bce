<?php

namespace AcMarche\Bce\Entity;

use AcMarche\Bce\Repository\BranchRepository;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity(fields: ['id'])]
#[ORM\Entity(repositoryClass: BranchRepository::class)]
#[ORM\Table(name: 'bce_branch')]
#[ORM\UniqueConstraint(name: 'branch_idx', columns: ['id'])]
class Branch implements Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    public int $idx;

    #[ORM\Column(type: 'string', length: 50, unique: true)]
    public string $id;

    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    public string $startDate;

    #[ORM\Column(type: 'string', length: 50, nullable: false, unique: true)]
    public string $enterpriseNumber;

    public function __toString(): string
    {
        return $this->id;
    }
}
