<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Invoice
 *
 * @ORM\Table(name="invoice", indexes={@ORM\Index(name="fk_invoice_category1_idx", columns={"idcategory"})})
 * @ORM\Entity
 */
class Invoice
{
    /**
     * @var string
     *
     * @ORM\Column(name="invoiceNumber", type="string", length=16, nullable=false)
     * @ORM\Id
     */
    private $invoicenumber;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float", precision=10, scale=0, nullable=false)
     */
    private $value;

    /**
     * @var \Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcategory", referencedColumnName="IDcategory")
     * })
     */
    private $idcategory;

    public function getInvoicenumber(): ?string
    {
        return $this->invoicenumber;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getIdcategory(): ?Category
    {
        return $this->idcategory;
    }

    public function setIdcategory(?Category $idcategory): self
    {
        $this->idcategory = $idcategory;

        return $this;
    }

    /**
     * Set the value of invoicenumber
     *
     * @param  int  $invoicenumber
     *
     * @return  self
     */ 
    public function setInvoicenumber(string $invoicenumber)
    {
        $this->invoicenumber = $invoicenumber;

        return $this;
    }
}
