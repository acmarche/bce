<?php

namespace AcMarche\Bce\Entity;

use AcMarche\Bce\Repository\ContactRepository;
use AcMarche\Bce\Entity\IdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 * ORM\Table(name="bce_contact", uniqueConstraints={
 *     ORM\UniqueConstraint(name="contact_idx", columns={"entity_number", "entity_contact", "contact_type"})})
 * UniqueEntity(fields={"entityNumber", "entityContact", "contactType"})
 */
class Contact
{
    use IdTrait;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    public string $entityNumber;
    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    public string $entityContact;
    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    public string $contactType;
    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    public string $value;

    public function __toString()
    {
        return $this->value;
    }

}
