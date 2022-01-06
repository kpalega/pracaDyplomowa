<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * News
 *
 * @ORM\Table(name="news", indexes={@ORM\Index(name="fk_news_user1_idx", columns={"IDuser"})})
 * @ORM\Entity
 */
class News
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDnews", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idnews;

    /**
     * @var string
     *
     * @ORM\Column(name="topic", type="string", length=255, nullable=false)
     */
    private $topic;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=16777215, nullable=false)
     */
    private $content;

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
     * @var \Attachment
     * 
     * @ORM\ManyToOne(targetEntity="Attachment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idAttachment", referencedColumnName="idAttachment")
     * })
     */
    private $idAttachment;

    public function getIdnews(): ?int
    {
        return $this->idnews;
    }
    

    public function getTopic(): ?string
    {
        return $this->topic;
    }

    public function setTopic(string $topic): self
    {
        $this->topic = $topic;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
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

    public function getAttachment(): ?Attachment
    {
        return $this->idAttachment;
    }

    public function setAttachment(?Attachment $idAttachment): self
    {
        $this->idAttachment = $idAttachment;

        return $this;
    }

}
