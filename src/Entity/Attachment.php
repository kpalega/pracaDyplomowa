<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="attachment")
 * @ORM\Entity
 */
class Attachment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="idAttachment", type="integer", nullable=false)
     */
    private $idAttachment;

    /**
     * @ORM\Column(name="filename", type="string", length=255, nullable=false)
     */
    private $filename;

    /**
     * @ORM\Column(name="path", type="string", length=255, nullable=false)
     */
    private $path;

    /**
     * @ORM\ManyToOne(targetEntity="News", inversedBy="attachments")
     * * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idnews", referencedColumnName="IDnews")
     * })
     */
    private $idnews;

    /**
     * @ORM\ManyToOne(targetEntity="Message", inversedBy="attachments")
     * * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idmessage", referencedColumnName="IDmessage")
     * })
     */
    private $idmessage;

    public function getId(): ?int
    {
        return $this->idattachment;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getNews(): ?News
    {
        return $this->idnews;
    }

    public function setNews(?News $news): self
    {
        $this->idnews = $news;

        return $this;
    } 
    
    public function getMessage(): ?Message
    {
        return $this->idmessage;
    }

    public function setMessage(?Message $message): self
    {
        $this->idmessage = $message;

        return $this;
    }
}
