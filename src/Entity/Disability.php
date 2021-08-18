<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Disability
 *
 * @ORM\Table(name="disability")
 * @ORM\Entity
 */
class Disability
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDdisability", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iddisability;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="decision", type="integer", nullable=false)
     */
    private $decision;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Child", mappedBy="iddisability")
     */
    private $idchild;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idchild = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIddisability(): ?int
    {
        return $this->iddisability;
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

    public function getDecision(): ?int
    {
        return $this->decision;
    }

    public function setDecision(int $decision): self
    {
        $this->decision = $decision;

        return $this;
    }

    /**
     * @return Collection|Child[]
     */
    public function getIdchild(): Collection
    {
        return $this->idchild;
    }

    public function addIdchild(Child $idchild): self
    {
        if (!$this->idchild->contains($idchild)) {
            $this->idchild[] = $idchild;
            $idchild->addIddisability($this);
        }

        return $this;
    }

    public function removeIdchild(Child $idchild): self
    {
        if ($this->idchild->removeElement($idchild)) {
            $idchild->removeIddisability($this);
        }

        return $this;
    }

}
