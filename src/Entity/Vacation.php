<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vacation
 *
 * @ORM\Table(name="vacation", indexes={@ORM\Index(name="fk_vacation_user1_idx", columns={"IDuser"})})
 * @ORM\Entity
 */
class Vacation
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDvacation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idvacation;

    /**
     * @var int
     *
     * @ORM\Column(name="vacationDays", type="integer", nullable=false)
     */
    private $vacationdays;

    /**
     * @var int
     *
     * @ORM\Column(name="workedYears", type="integer", nullable=false)
     */
    private $workedyears;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDuser", referencedColumnName="IDuser")
     * })
     */
    private $iduser;

    public function getIdvacation(): ?int
    {
        return $this->idvacation;
    }

    public function getVacationdays(): ?int
    {
        return $this->vacationdays;
    }

    public function setVacationdays(int $vacationdays): self
    {
        $this->vacationdays = $vacationdays;

        return $this;
    }

    public function getWorkedyears(): ?int
    {
        return $this->workedyears;
    }

    public function setWorkedyears(int $workedyears): self
    {
        $this->workedyears = $workedyears;

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


}
