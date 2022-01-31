<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity
 */
class Event
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDevent", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idevent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_event", type="datetime", nullable=false)
     */
    private $startEvent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_event", type="datetime", nullable=false)
     */
    private $endEvent;
    
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;


    

    /**
     * Get the value of idevent
     *
     * @return  int
     */ 
    public function getIdevent()
    {
        return $this->idevent;
    }

    /**
     * Set the value of idevent
     *
     * @param  int  $idevent
     *
     * @return  self
     */ 
    public function setIdevent(int $idevent)
    {
        $this->idevent = $idevent;

        return $this;
    }

    /**
     * Get the value of startEvent
     *
     * @return  \DateTime
     */ 
    public function getStartEvent()
    {
        return $this->startEvent;
    }

    /**
     * Set the value of startEvent
     *
     * @param  \DateTime  $startEvent
     *
     * @return  self
     */ 
    public function setStartEvent(\DateTime $startEvent)
    {
        $this->startEvent = $startEvent;

        return $this;
    }

    /**
     * Get the value of endEvent
     *
     * @return  \DateTime
     */ 
    public function getEndEvent()
    {
        return $this->endEvent;
    }

    /**
     * Set the value of endEvent
     *
     * @param  \DateTime  $endEvent
     *
     * @return  self
     */ 
    public function setEndEvent(\DateTime $endEvent)
    {
        $this->endEvent = $endEvent;

        return $this;
    }

    /**
     * Get the value of title
     *
     * @return  string
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @param  string  $title
     *
     * @return  self
     */ 
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }
}