<?php

namespace AcMarche\Bce\Entity;

use AcMarche\Bce\Repository\MetaRepository;
use AcMarche\Bce\Entity\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=MetaRepository::class)
 * @ORM\Table(name="bce_meta", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="meta_idx", columns={"variable"})})
 * @UniqueEntity(fields={"variable"})
 */
class Meta
{
    use IdTrait;

    /**
     * @ORM\Column(type="string", length=150, nullable=false, unique=true)
     */
    public string $variable;
    /**
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    public string $value;

    public function __toString()
    {
        return $this->variable;
    }
}
