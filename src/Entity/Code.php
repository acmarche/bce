<?php

namespace AcMarche\Bce\Entity;

use AcMarche\Bce\Repository\CodeRepository;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity(fields: ['code', 'language', 'category'])]
#[ORM\Entity(repositoryClass: CodeRepository::class)]
#[ORM\Table(name: 'bce_code')]
#[ORM\UniqueConstraint(name: 'code_idx', columns: ['code', 'language', 'category'])]
class Code implements Stringable
{
    use IdTrait;
    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    public string $category;
    #[ORM\Column(type: 'string', length: 15, nullable: false)]
    public string $code;
    #[ORM\Column(type: 'string', length: 5, nullable: false)]
    public string $language;
    #[ORM\Column(type: 'string', length: 250, nullable: false)]
    public string $description;

    public function __toString(): string
    {
        return $this->code;
    }
}
