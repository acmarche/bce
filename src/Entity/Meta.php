<?php

namespace AcMarche\Bce\Entity;

use AcMarche\Bce\Repository\MetaRepository;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity(fields: ['variable'])]
#[ORM\Entity(repositoryClass: MetaRepository::class)]
#[ORM\Table(name: 'bce_meta')]
#[ORM\UniqueConstraint(name: 'meta_idx', columns: ['variable'])]
class Meta implements Stringable
{
    use IdTrait;
    #[ORM\Column(type: 'string', length: 150, nullable: false, unique: true)]
    public string $variable;
    #[ORM\Column(type: 'string', length: 150, nullable: false)]
    public string $value;

    public function __toString(): string
    {
        return $this->variable;
    }
}
