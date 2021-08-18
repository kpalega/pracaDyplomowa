<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Child
 *
 * @ORM\Table(name="child")
 * @ORM\Entity
 */
class Child
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDchild", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idchild;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=45, nullable=false)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=45, nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=45, nullable=false)
     */
    private $password;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Activities", inversedBy="idchild")
     * @ORM\JoinTable(name="child_has_activities",
     *   joinColumns={
     *     @ORM\JoinColumn(name="IDchild", referencedColumnName="IDchild")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="IDactivity", referencedColumnName="IDactivity")
     *   }
     * )
     */
    private $idactivity;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Disability", inversedBy="idchild")
     * @ORM\JoinTable(name="child_has_disability",
     *   joinColumns={
     *     @ORM\JoinColumn(name="IDchild", referencedColumnName="IDchild")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="IDdisability", referencedColumnName="IDdisability")
     *   }
     * )
     */
    private $iddisability;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Group", inversedBy="idchild")
     * @ORM\JoinTable(name="child_has_group",
     *   joinColumns={
     *     @ORM\JoinColumn(name="IDchild", referencedColumnName="IDchild")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="IDclass", referencedColumnName="IDclass")
     *   }
     * )
     */
    private $idclass;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idactivity = new \Doctrine\Common\Collections\ArrayCollection();
        $this->iddisability = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idclass = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdchild(): ?int
    {
        return $this->idchild;
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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection|Activities[]
     */
    public function getIdactivity(): Collection
    {
        return $this->idactivity;
    }

    public function addIdactivity(Activities $idactivity): self
    {
        if (!$this->idactivity->contains($idactivity)) {
            $this->idactivity[] = $idactivity;
        }

        return $this;
    }

    public function removeIdactivity(Activities $idactivity): self
    {
        $this->idactivity->removeElement($idactivity);

        return $this;
    }

    /**
     * @return Collection|Disability[]
     */
    public function getIddisability(): Collection
    {
        return $this->iddisability;
    }

    public function addIddisability(Disability $iddisability): self
    {
        if (!$this->iddisability->contains($iddisability)) {
            $this->iddisability[] = $iddisability;
        }

        return $this;
    }

    public function removeIddisability(Disability $iddisability): self
    {
        $this->iddisability->removeElement($iddisability);

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getIdclass(): Collection
    {
        return $this->idclass;
    }

    public function addIdclass(Group $idclass): self
    {
        if (!$this->idclass->contains($idclass)) {
            $this->idclass[] = $idclass;
        }

        return $this;
    }

    public function removeIdclass(Group $idclass): self
    {
        $this->idclass->removeElement($idclass);

        return $this;
    }

}
