<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Group
 *
 * @ORM\Table(name="group")
 * @ORM\Entity
 */
class Group
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDclass", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idclass;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=75, nullable=false)
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Child", mappedBy="idclass")
     */
    private $idchild;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idchild = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdclass(): ?int
    {
        return $this->idclass;
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
            $idchild->addIdclass($this);
        }

        return $this;
    }

    public function removeIdchild(Child $idchild): self
    {
        if ($this->idchild->removeElement($idchild)) {
            $idchild->removeIdclass($this);
        }

        return $this;
    }

}
