<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity
 */
class Message
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDmessage", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idmessage;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=16777215, nullable=false)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="topic", type="string", length=255, nullable=false)
     */
    private $topic;

    /**
     * @var bool
     *
     * @ORM\Column(name="achived", type="boolean", nullable=false)
     */
    private $achived;

    /**
     * @var bool
     *
     * @ORM\Column(name="seen", type="boolean", nullable=false)
     */
    private $seen = '0';
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="idmessage")
     */
    private $iduser;

    /**
     * @ORM\OneToMany(targetEntity="Attachment", mappedBy="message")
     */
    private $attachments;

    
    /**
     * @var \App\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fromUser", referencedColumnName="IDuser")
     * })
     */
    private $fromUser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->iduser = new \Doctrine\Common\Collections\ArrayCollection();
        $this->attachments = new ArrayCollection();
    }

    public function getIdmessage(): ?int
    {
        return $this->idmessage;
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

    public function getTopic(): ?string
    {
        return $this->topic;
    }

    public function setTopic(string $topic): self
    {
        $this->topic = $topic;

        return $this;
    }

    public function getAchived(): ?bool
    {
        return $this->achived;
    }

    public function setAchived(bool $achived): self
    {
        $this->achived = $achived;

        return $this;
    }

    public function getSeen(): ?bool
    {
        return $this->seen;
    }

    public function setSeen(bool $seen): self
    {
        $this->seen = $seen;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getIduser(): Collection
    {
        return $this->iduser;
    }

    public function addIduser(User $iduser): self
    {
        if (!$this->iduser->contains($iduser)) {
            $this->iduser[] = $iduser;
            $iduser->addIdmessage($this);
        }

        return $this;
    }

    public function removeIduser(User $iduser): self
    {
        if ($this->iduser->removeElement($iduser)) {
            $iduser->removeIdmessage($this);
        }

        return $this;
    }

        /**
     * @return Collection|Attachment[]
     */
    public function getAttachments(): Collection
    {
        return $this->attachments;
    }

    public function addAttachment(Attachment $attachment): self
    {
        if (!$this->attachments->contains($attachment)) {
            $this->attachments[] = $attachment;
            $attachment->setMessage($this);
        }

        return $this;
    }

    public function removeAttachment(Attachment $attachment): self
    {
        if ($this->attachments->removeElement($attachment)) {
            // set the owning side to null (unless already changed)
            if ($attachment->getMessage() === $this) {
                $attachment->setMessage(null);
            }
        }

        return $this;
    }


    /**
     * Get the value of date
     *
     * @return  \DateTime
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @param  \DateTime  $date
     *
     * @return  self
     */ 
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }



    /**
     * Get the value of fromUser
     *
     * @return  \App\Entity\User
     */ 
    public function getFromUser()
    {
        return $this->fromUser;
    }

    /**
     * Set the value of fromUser
     *
     * @param  \App\Entity\User  $fromUser
     *
     * @return  self
     */ 
    public function setFromUser(\App\Entity\User $fromUser)
    {
        $this->fromUser = $fromUser;

        return $this;
    }
}
