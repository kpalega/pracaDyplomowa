<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user", indexes={@ORM\Index(name="fk_user_specialization1_idx", columns={"IDspecialization"})})
 * @ORM\Entity
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDuser", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iduser;

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
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=10, nullable=false)
     */
    private $role;

    /**
     * @var \Specialization
     *
     * @ORM\ManyToOne(targetEntity="Specialization")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDspecialization", referencedColumnName="IDspecialization")
     * })
     */
    private $idspecialization;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Message", inversedBy="iduser")
     * @ORM\JoinTable(name="user_saw_message",
     *   joinColumns={
     *     @ORM\JoinColumn(name="IDuser", referencedColumnName="IDuser")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="IDmessage", referencedColumnName="IDmessage")
     *   }
     * )
     */
    private $idmessage;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idmessage = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getIdspecialization(): ?Specialization
    {
        return $this->idspecialization;
    }

    public function setIdspecialization(?Specialization $idspecialization): self
    {
        $this->idspecialization = $idspecialization;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getIdmessage(): Collection
    {
        return $this->idmessage;
    }

    public function addIdmessage(Message $idmessage): self
    {
        if (!$this->idmessage->contains($idmessage)) {
            $this->idmessage[] = $idmessage;
        }

        return $this;
    }

    public function removeIdmessage(Message $idmessage): self
    {
        $this->idmessage->removeElement($idmessage);

        return $this;
    }

}
