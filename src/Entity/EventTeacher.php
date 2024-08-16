<?php

namespace App\Entity;

use App\Repository\EventTeacherRepository;
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
}
