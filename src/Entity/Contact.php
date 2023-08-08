<?php

namespace AcMarche\Bce\Entity;

use AcMarche\Bce\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Stringable;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact implements Stringable
{
    use IdTrait;
    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    public string $entityNumber;

    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    public string $entityContact;

    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    public string $contactType;

    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    public string $value;

    public function __toString(): string
    {
        return $this->value;
    }
}
