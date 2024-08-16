<?php

namespace App\Entity;

use App\Repository\EventTeacherRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'event_teacher')]
#[ORM\UniqueConstraint(name: 'event_teacher', columns: ['teacher_id', 'event_id'])]
#[ORM\Entity(repositoryClass: EventTeacherRepository::class)]
class EventTeacher
{ 
    #[ORM\Id]
    #[ORM\JoinColumn(name: 'event_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity: Event::class, inversedBy: 'comoderator')]
    private $event;
    
    #[ORM\Id]
    #[ORM\JoinColumn(name: 'teacher_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity: Teacher::class, inversedBy: 'coevent')]
    private $teacher; 
    
    #[ORM\Column(nullable: true)]
    private ?DateTime $starttime = null;

    #[ORM\Column(nullable: true)]
    private ?DateTime $endtime = null;

    #[ORM\Column(nullable: true)]
    private ?int $onlineTime = null;

    #[ORM\Column(nullable: true)]
    private ?int $talkTime = null;

    #[ORM\Column(nullable: true)]
    private ?int $webcamTime = null;

    #[ORM\Column(nullable: true)]
    private ?int $messageCount = null;

    #[ORM\Column(nullable: true)]
    private ?int $connectionCount = null;

    #[ORM\Column(nullable: true)]
    private ?array $emojis = null;


    // To string method to return the event and teacher
    public function __toString(): string
    {
        return $this->event->getMeetingName() . ' - ' . $this->teacher->getFullName();
    }

    public function getEvent(): Event
    {
        return $this->event;
    }

    public function setEvent(Event $event): self
    {
        $this->event = $event;
        $event->addComoderator($this);

        return $this;
    }

    public function getTeacher(): Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(Teacher $teacher): self
    {
        $this->teacher = $teacher;
        $teacher->addCoevent($this);

        return $this;
    }


    public function getStartTime(): ?DateTime
    {
        return $this->starttime;
    }

    public function setStartTime(?DateTime $starttime): self
    {
        $this->starttime = $starttime;

        return $this;
    }

    public function getEndTime(): ?DateTime
    {
        return $this->endtime;
    }

    public function setEndTime(?DateTime $endtime): self
    {
        $this->endtime = $endtime;

        return $this;
    }

    public function getOnlineTime(): ?int
    {
        return $this->onlineTime;
    }

    public function setOnlineTime(?int $onlineTime): self
    {
        $this->onlineTime = $onlineTime;

        return $this;
    }

    public function getTalkTime(): ?int
    {
        return $this->talkTime;
    }

    public function setTalkTime(?int $talkTime): self
    {
        $this->talkTime = $talkTime;

        return $this;
    }

    public function getWebcamTime(): ?int
    {
        return $this->webcamTime;
    }

    public function setWebcamTime(?int $webcamTime): self
    {
        $this->webcamTime = $webcamTime;

        return $this;
    }

    public function getMessageCount(): ?int
    {
        return $this->messageCount;
    }

    public function setMessageCount(?int $messageCount): self
    {
        $this->messageCount = $messageCount;

        return $this;
    }

    public function getConnectionCount(): ?int
    {
        return $this->connectionCount;
    }

    public function setConnectionCount(?int $connectionCount): self
    {
        $this->connectionCount = $connectionCount;

        return $this;
    }

    public function getEmojis(): ?array
    {
        return $this->emojis;
    }

    public function setEmojis(?array $emojis): self
    {
        $this->emojis = $emojis;

        return $this;
    }

}
