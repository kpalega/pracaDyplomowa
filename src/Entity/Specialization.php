<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Specialization
 *
 * @ORM\Table(name="specialization")
 * @ORM\Entity
 */
class Specialization
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDspecialization", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idspecialization;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="academicTitle", type="string", length=45, nullable=true)
     */
    private $academictitle;

    public function getIdspecialization(): ?int
    {
        return $this->idspecialization;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAcademictitle(): ?string
    {
        return $this->academictitle;
    }

    public function setAcademictitle(?string $academictitle): self
    {
        $this->academictitle = $academictitle;

        return $this;
    }


}
