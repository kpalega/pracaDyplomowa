<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Homework
 *
 * @ORM\Table(name="homework", indexes={@ORM\Index(name="fk_homework_group1_idx", columns={"IDclass"})})
 * @ORM\Entity
 */
class Homework
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDhomework", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idhomework;

    /**
     * @var string
     *
     * @ORM\Column(name="todo", type="text", length=16777215, nullable=false)
     */
    private $todo;

    /**
     * @var bool
     *
     * @ORM\Column(name="done", type="boolean", nullable=false)
     */
    private $done;

    /**
     * @var \Group
     *
     * @ORM\ManyToOne(targetEntity="Group")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDclass", referencedColumnName="IDclass")
     * })
     */
    private $idclass;

    public function getIdhomework(): ?int
    {
        return $this->idhomework;
    }

    public function getTodo(): ?string
    {
        return $this->todo;
    }

    public function setTodo(string $todo): self
    {
        $this->todo = $todo;

        return $this;
    }

    public function getDone(): ?bool
    {
        return $this->done;
    }

    public function setDone(bool $done): self
    {
        $this->done = $done;

        return $this;
    }

    public function getIdclass(): ?Group
    {
        return $this->idclass;
    }

    public function setIdclass(?Group $idclass): self
    {
        $this->idclass = $idclass;

        return $this;
    }


}
