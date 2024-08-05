<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cours
 */
#[ORM\Table(name: 'cours')]
#[ORM\Index(name: 'IDX_FDCA8C9C71F7E88B', columns: ['event_id'])]
#[ORM\Index(name: 'IDX_FDCA8C9CA6CC7B2', columns: ['eleve_id'])]
#[ORM\UniqueConstraint(name: 'course_inscription', columns: ['eleve_id', 'event_id'])]
#[ORM\Entity(repositoryClass: '\App\Repository\CoursRepository')]
class Cours {
    
    /**
     * @var int
     */
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;
    
    /**
     * @var \DateTime|null
     */
    #[ORM\Column(name: 'starttime', type: 'datetime', nullable: true)]
    private $starttime;
    
    /**
     * @var \DateTime|null
     */
    #[ORM\Column(name: 'endtime', type: 'datetime', nullable: true)]
    private $endtime;
    
    /**
     * @var string
     */
    #[ORM\Column(name: 'course_url', type: 'string', length: 255, nullable: true)]
    private $course_url;
    
    /**
     * @var string
     */
    #[ORM\Column(name: 'note', type: 'string', length: 10, nullable: false)]
    private $note = "";
    
    /**
     * @var \App\Entity\Event
     */
    #[ORM\ManyToOne(targetEntity: 'Event', inversedBy: 'coursInscrits', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'event_id', referencedColumnName: 'id')]
    private $event;
    
    /**
     * @var \App\Entity\Eleve
     */
    #[ORM\JoinColumn(name: 'eleve_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity: '\App\Entity\Eleve', inversedBy: 'coursSuivis', cascade: ['persist'])]
    private $eleve;
    
    private $ListeEvents;
    private $ListeEleves;
    private $ListeInscrits;
    private $ListeGroupes;
    private $ListeGroupesInscrits;

    #[ORM\Column(type: 'time', nullable: true)]
    private $creneaustart;

    #[ORM\Column(type: 'time', nullable: true)]
    private $creneauend;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $signature = null;

    #[ORM\Column(options:['default' => 0])]
    private ?bool $certif = false;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $signaturetime = null;

    #[ORM\Column(nullable: true)]
    private ?int $externalId = null;

    #[ORM\Column(nullable: true)]
    private ?int $talkTime = null;

    #[ORM\Column(nullable: true)]
    private ?array $emojis = null;

    #[ORM\Column(nullable: true)]
    private ?int $webcamTime = null;

    #[ORM\Column(nullable: true)]
    private ?int $messageCount = null;
    
    public function __construct() {
        //$this->eleve = new \Doctrine\Common\Collections\ArrayCollection();
        //$this->events = $this->cours = new \Doctrine\Common\Collections\ArrayCollection();
        
    }
    
    public function __toString() {
        return (string) $this->getCourseUrl();
    }
    
    public function __get($propertyName)
    {
        return $this->$propertyName;
    }

    public function __isset($propertyName) : bool
    {
        return isset($this->$propertyName);
    }
    

    public function getId() {
        return $this->id;
    }

    public function getEleve() {
        return $this->eleve;
    }

    function getEvent() {
        return $this->event;
    }

    public function getCourse_url() {
        return $this->course_url;
    }

    public function getStartTime() {
        return $this->starttime;
    }

    public function getEndTime() {
        return $this->endtime;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setEleve(\App\Entity\Eleve $eleve) {
        $this->eleve = $eleve;
        return $this;
    }

    public function setEvent(\App\Entity\Event $event) {
        $this->event = $event;
    }
    
    public function setCourse_url($course_url) {
        $this->course_url = $course_url;
    }

    public function setStartTime($starttime) {
        $this->starttime = $starttime;
    }

    public function setEndTime($endtime) {
        $this->endtime = $endtime;
    }

    public function setListeEvents($listeEvents = array()) {
        $this->ListeEvents= $listeEvents;
        return $this;
    }
    
    /**
     * Get Events
     *
     * @return array
     */ 
    public function getListeEvents() {
        return $this->ListeEvents;
    }
    
    public function setListeEleves($listeEleves = array()) {
        $this->ListeEleves= $listeEleves;
        return $this;
    }
    
    function setListeGroupes($listeGroupes = array()) {
        $this->ListeGroupes = $listeGroupes;
        return $this;
    }
    
    /**
     * Get Eleves
     *
     * @return array
     */ 
    public function getListeEleves() {
        return $this->ListeEleves;
    }
     /**
     * Get Groupe
     *
     * @return array
     */ 
    function getListeGroupes() {
        return $this->ListeGroupes;
    }
    

    /**
     * Set courseUrl.
     *
     * @param string $courseUrl
     *
     * @return Cours
     */
    public function setCourseUrl($courseUrl)
    {
        $this->course_url = $courseUrl;

        return $this;
    }

    /**
     * Get courseUrl.
     *
     * @return string
     */
    public function getCourseUrl()
    {
        return $this->course_url;
    }

    /**
     * Set note.
     *
     * @param integer $note
     *
     * @return Cours
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note.
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    public function getListeInscrits() {
        return $this->ListeInscrits;
    }

    public function getListeGroupesInscrits() {
        return $this->ListeGroupesInscrits;
    }

    public function getCreneaustart(): ?\DateTime
    {
        return $this->creneaustart;
    }

    public function setCreneaustart(?\DateTime $creneaustart): self
    {
        $this->creneaustart = $creneaustart;

        return $this;
    }

    public function getCreneauend(): ?\DateTime
    {
        return $this->creneauend;
    }

    public function setCreneauend(?\DateTime $creneauend): self
    {
        $this->creneauend = $creneauend;

        return $this;
    }

    public function getSignature()
    {
        return $this->signature;
    }

    public function setSignature($signature): self
    {
        $this->signature = $signature;

        return $this;
    }

    public function isCertif(): ?bool
    {
        return $this->certif;
    }

    public function setCertif(bool $certif): self
    {
        $this->certif = $certif;

        return $this;
    }

    public function getSignaturetime(): ?\DateTimeInterface
    {
        return $this->signaturetime;
    }

    public function setSignaturetime(?\DateTimeInterface $signaturetime): self
    {
        $this->signaturetime = $signaturetime;

        return $this;
    }

    public function getExternalId(): ?int
    {
        return $this->externalId;
    }

    public function setExternalId(?int $externalId): static
    {
        $this->externalId = $externalId;

        return $this;
    }

    public function getTalkTime(): ?int
    {
        return $this->talkTime;
    }

    public function setTalkTime(?int $talkTime): static
    {
        $this->talkTime = $talkTime;

        return $this;
    }

    public function getOnlineTime(): ?int
    {
        return $this->onlineTime;
    }

    public function setOnlineTime(?int $onlineTime): static
    {
        $this->onlineTime = $onlineTime;

        return $this;
    }

    public function getMessageCount(): ?int
    {
        return $this->messageCount;
    }

    public function setMessageCount(?int $messageCount): static
    {
        $this->messageCount = $messageCount;

        return $this;
    }

    public function getEmojis(): ?array
    {
        return $this->emojis;
    }

    public function setEmojis(?array $emojis): static
    {
        $this->emojis = $emojis;

        return $this;
    }

    public function getWebcamTime(): ?int
    {
        return $this->webcamTime;
    }

    public function setWebcamTime(?int $webcamTime): static
    {
        $this->webcamTime = $webcamTime;

        return $this;
    }

}

