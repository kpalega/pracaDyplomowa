<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * Activities
 *
 * @ORM\Table(name="activities", indexes={@ORM\Index(name="fk_activities_user1_idx", columns={"IDuser"})})
 * @ORM\Entity
 */
class Activities
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDactivity", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idactivity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDuser", referencedColumnName="IDuser")
     * })
     */
    private $iduser;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Child", mappedBy="idactivity")
     */
    private $idchild;

    /**
     * @var boolean
     *
     * @ORM\Column(name="presence", type="boolean", length=45, nullable=false)
     */
    private $presence;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idchild = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdactivity(): ?int
    {
        return $this->idactivity;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIduser(): ?User
    {
        return $this->iduser;
    }

    public function setIduser(?User $iduser): self
    {
        $this->iduser = $iduser;

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
            $idchild->addIdactivity($this);
        }

        return $this;
    }

    public function removeIdchild(Child $idchild): self
    {
        if ($this->idchild->removeElement($idchild)) {
            $idchild->removeIdactivity($this);
        }

        return $this;
    }


    /**
     * Get the value of presence
     *
     * @return  boolean
     */ 
    public function getPresence()
    {
        return $this->presence;
    }

    /**
     * Set the value of presence
     *
     * @return  self
     */ 
    public function setPresence(bool $presence)
    {
        $this->presence = $presence;

        return $this;
    }
}
