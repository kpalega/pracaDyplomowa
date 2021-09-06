<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDcategory", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcategory;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;
    
    /**
     * @var float
     *
     * @ORM\Column(name="value",  type="float", precision=10, scale=0, nullable=false)
     */
    private $value;

    /**
     * @var float
     *
     * @ORM\Column(name="specialValue",  type="float", precision=10, scale=0, nullable=false)
     */
    private $specialValue;

    public function getIdcategory(): ?int
    {
        return $this->idcategory;
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
     * Get the value of value
     *
     * @return  float
     */ 
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @param  float  $value
     *
     * @return  self
     */ 
    public function setValue(float $value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of specialValue
     *
     * @return  float
     */ 
    public function getSpecialValue()
    {
        return $this->specialValue;
    }

    /**
     * Set the value of specialValue
     *
     * @param  float  $specialValue
     *
     * @return  self
     */ 
    public function setSpecialValue(float $specialValue)
    {
        $this->specialValue = $specialValue;

        return $this;
    }
}
