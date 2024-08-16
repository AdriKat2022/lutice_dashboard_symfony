<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 */
#[ORM\Table(name: 'event')]
#[ORM\Index(name: 'IDX_3BAE0AA741807E1D', columns: ['teacher_id'])]
// #[ORM\Index(name: 'IDX_3BAE0AA75FB14BA7', columns: ['level_id'])]
// #[ORM\Index(name: 'IDX_3BAE0AA7C32A47EE', columns: ['school_id'])]
// #[ORM\Index(name: 'IDX_3BAE0AA7A5522701', columns: ['discipline_id'])]
// #[ORM\Index(name: 'IDX_3BAE0AA7357C0A59', columns: ['tarif_id'])]    
#[ORM\Entity(repositoryClass: '\App\Repository\EventRepository')]
class Event
{
    
    const ORANGE = '#ff7043';
    const RED = '#ff1744';
    const PINK = '#E6007E';
    
    /**
     * @var int
     */
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;

    /**
     * @var \DateTime
     */
    #[ORM\Column(name: 'start', type: 'datetime', nullable: false)]
    private $start;

    /**
     * @var \DateTime
     */
    #[ORM\Column(name: 'end', type: 'datetime', nullable: false)]
    private $end;

    /**
     * @var string
     */
    #[ORM\Column(name: 'color', type: 'string', length: 255, nullable: false)]
    private $color;
    
    /**
     * @var int
     */
    #[ORM\Column(name: 'participants_max', type: 'integer', nullable: false)]
    private $participants_max;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'mcdescription', type: 'text', length: 0, nullable: true)]
    private $mcdescription;
    
    /**
     * @var bool
     */
    #[ORM\Column(name: 'masterclass', type: 'boolean', nullable: false)]
    private $masterclass;
    
    /**
     * @var int
     */
    #[ORM\Column(name: 'status', type: 'integer', nullable: false)]
    private $status;

    /**
     * @var int
     */
    #[ORM\Column(name: 'id_availability', type: 'integer', nullable: false)]
    private $id_availability;
    
   /**
     * @var bool|null
     */
    #[ORM\Column(name: 'note_resultat', type: 'boolean', nullable: true)]
    private $note_resultat = 0; 
    
       /**
     * @var bool|null
     */
    #[ORM\Column(name: 'creneau', type: 'boolean', nullable: true)]
    private $creneau = 0; 
    
    /**
     * @var string|null
     */
    #[ORM\Column(name: 'invitations', type: 'text', length: 0, nullable: true)]
    private $invitations;
    
//     /**
//      * @var \App\Entity\Tarif
//      */
//     #[ORM\JoinColumn(name: 'tarif_id', referencedColumnName: 'id')]
//     #[ORM\ManyToOne(targetEntity: '\App\Entity\Tarif')]
//     private $id_tarif;
    
    /**
     * @var \App\Entity\Teacher
     */
    #[ORM\JoinColumn(name: 'teacher_id', referencedColumnName: 'id')]
    #[ORM\ManyToOne(targetEntity: '\App\Entity\Teacher', inversedBy: 'event')]
    private $teacher;
    
//     /**
//      * @var \App\Entity\Level
//      */
//     #[ORM\JoinColumn(name: 'level_id', referencedColumnName: 'id')]
//     #[ORM\ManyToOne(targetEntity: '\App\Entity\Level')]
//     private $level;
//     
//     /**
//      * @var \App\Entity\Discipline
//      */
//     #[ORM\JoinColumn(name: 'discipline_id', referencedColumnName: 'id')]
//     #[ORM\ManyToOne(targetEntity: '\App\Entity\Discipline', inversedBy: 'event')]
//     private $discipline;
//     
//     /**
//      * @var \App\Entity\School
//      */
//     #[ORM\JoinColumn(name: 'school_id', referencedColumnName: 'id')]
//     #[ORM\ManyToOne(targetEntity: '\App\Entity\School', inversedBy: 'event')]
//     private $school;
    
    /**
     * @var \App\Entity\Meeting
     */
    #[ORM\OneToOne(targetEntity: '\App\Entity\Meeting', mappedBy: 'event', cascade: ['all'])]
    private $meeting;
    
//     /**
//      * @var \Doctrine\Common\Collections\Collection
//      */
//     #[ORM\ManyToMany(targetEntity: '\App\Entity\Qcminfo', mappedBy: 'events')]
//     private $qcms;
//     
//     /**
//      * @var \Doctrine\Common\Collections\Collection
//      */
//     #[ORM\OneToMany(targetEntity: '\App\Entity\Avis', mappedBy: 'event')]
//     private $aviss;
    
//     /**
//      * @var \App\Entity\Groupe
//      */
//     #[ORM\ManyToMany(targetEntity: '\App\Entity\Groupe', inversedBy: 'events')]
//     #[ORM\JoinColumn(nullable: false, onDelete:'CASCADE')]
//     private $groupes;

    /**
     * @var \App\Entity\Cours
     *
     * One Events have Many Eleves.
     */
    #[ORM\OneToMany(targetEntity: '\App\Entity\Cours', mappedBy: 'event', orphanRemoval: true)]
    #[ORM\JoinColumn(nullable: false)]
    private $coursInscrits;
    
    
    
//     /**
//      * @var \App\Entity\Image
//      */
//     #[ORM\ManyToOne(targetEntity: '\App\Entity\Image', cascade: ['persist'])]
//     #[ORM\JoinColumn(nullable: true)]
//     private $image;
//     
//     /**
//      * @var \App\Entity\CoursFiles
//      *
//      * One Events have Many Files.
//      */
//     #[ORM\OneToMany(targetEntity: '\App\Entity\CoursFiles', mappedBy: 'event', cascade: ['persist'])]
//     private $fileAdded;
    
    //Hors BDD
    
    /**
     * @var string
     */
    private $meetingName;
    
    /**
     *
     * @var boolean
     */
    private $autorecord = true;
    
    /**
     *
     * @var boolean
     */
    private $webcamsonlyformoderator = true;
    
    
    private ?bool $replayonlyforadmin = false;
    
    /**
     * @var array
     */
    private $disciplinelevels;
    
     /**
     * @var string
     */
    private $listdisciplinelevels;
    
    private $filesUsed;

    #[ORM\OneToMany(targetEntity: Teacher::class, mappedBy: 'event')]
    private $comoderator;

//     #[ORM\OneToMany(targetEntity: Share::class, mappedBy: 'event')]
//     private $shares;

    #[ORM\Column(type: 'boolean')]
    private $job;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $jobstart;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $jobend;
    
    private $tarif;
    private $qcm;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastUpdate = null;

//     #[ORM\ManyToOne]
//     private ?User $userUpdate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $externalId = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $signature = null;

    #[ORM\Column(options:['default' => 0])]
    private ?bool $certif = false;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $signaturetime = null;

    CONST EVENTCREATED=0;
    CONST EVENTSTARTED=1;
    CONST EVENTENDED=2;

    public function __construct()
    {
        
//        $this->aviss = new ArrayCollection();
        $this->coursInscrits = new ArrayCollection();
        $this->qcms = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        //$this->eleves = new \Doctrine\Common\Collections\ArrayCollection();
        //$this->cours = new \Doctrine\Common\Collections\ArrayCollection();
        //$this->filesUsed=new ArrayCollection();
        $this->comoderator = new ArrayCollection();
        $this->shares = new ArrayCollection();
        $this->job = false;
    }
    
    
    /*
     * @var string
     */
    //private $varstring;
    // A Vérifier
    public function __toString() {
        return (string)$this->getMeeting()->getMeetingName();
    }
    
    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    
    
    /**
     * Set start
     *
     * @param \DateTime $start
     *
     * @return Event
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     *
     * @return Event
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Event
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    function getFileAdded() {
        return $this->fileAdded;
    }

    function setFileAdded($fileAdded) {
        $this->fileAdded = $fileAdded;
        return $this;
    }

        
    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Event
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set idAvailability
     *
     * @param integer $idAvailability
     *
     * @return Event
     */
    public function setIdAvailability($idAvailability)
    {
        $this->id_availability = $idAvailability;

        return $this;
    }

    /**
     * Get idAvailability
     *
     * @return integer
     */
    public function getIdAvailability()
    {
        return $this->id_availability;
    }
    
    /**
     * Set meeting
     *
     * @param \App\Entity\Meeting $meeting
     *
     * @return Event
     */
    public function setMeeting(\App\Entity\Meeting $meeting = null)
    {
        $this->meeting = $meeting;

        return $this;
    }

    /**
     * Get Masterclass titre
     *
     * @return text
     */
    public function getMeetingName() {
        return $this->meetingName;
    }
    
    function getCoursInscrits() {
        return $this->coursInscrits ;
    }

    function setCoursInscrits($coursInscrits) {
        $this->coursInscrits = $coursInscrits;
    }
            
    /**
     * Set Participants_max
     *
     * @param \App\Entity\Meeting $meetingName
     *
     * @return Meeting
     */
    function  setMeetingName($meetingName) {
        $this->meetingName = $meetingName;
        return $this;
    }

    /**
     * Set Participants_max
     *
     * @param \App\Entity\Meeting $participants_max
     *
     * @return Event
     */
    function setParticipantsMax($participants_max) {
        $this->participants_max = $participants_max;
        return $this;
        
    }
    
    /**
     * Get meeting
     *
     * @return \App\Entity\Meeting
     */
    public function getMeeting()
    {
        return $this->meeting;
    }

    /**
     * Get Participants_max
     *
     * @return integer
     * 
     */
    
    function getParticipantsMax() {
        return $this->participants_max;
    }

    function getparticipants_max() {
        $this->getParticipantsMax();
        //return $this->participants_max;
    }
    
    /**
     * Get Place_disponibles
     *
     * @return integer
     * 
     */
    
    /*function getPlacesDisponibles() {
        dump($this->getEleves()); die();
        return $this->getParticipantsMax() - $this->getEleves();
    }*/
    
    /**
     * Set school
     *
     * @param \App\Entity\School $school
     *
     * @return Event
     */
    public function setSchool(\App\Entity\School $school = null)
    {
        $this->school = $school;

        return $this;
    }

    /**
     * Get school
     *
     * @return \App\Entity\School
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * Set teacher
     *
     * @param \App\Entity\Teacher $teacher
     *
     * @return Event
     */
    public function setTeacher(\App\Entity\Teacher $teacher = null)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return \App\Entity\Teacher
     */
    public function getTeacher()
    {
        return $this->teacher;
    }
    
     /**
     * Set eleve
     *
     * @param \App\Entity\Eleve $eleve
     *
     * @return Eleve
     */
    /*public function setEleves(\App\Entity\Eleve $eleve = null)
    {
        $this->eleve = $eleve;

        return $this;
    }*/

    /**
     * Get eleve
     *
     * @return arrayCollection|Cours[]
     */
    /*public function getEleves()
    {
        return $this->eleves;
    }*/

    /**
     * Set discipline
     *
     * @param \App\Entity\Discipline $discipline
     *
     * @return Event
     */
    public function setDiscipline(\App\Entity\Discipline $discipline = null)
    {
        $this->discipline = $discipline;

        return $this;
    }

    /**
     * Get discipline
     *
     * @return \App\Entity\Discipline
     */
    public function getDiscipline()
    {
        return $this->discipline;
    }

    /**
     * Get discipline
     *
     * @return \App\Entity\Discipline
     */
    public function getDisciplineId()
    {
        return $this->discipline->getId();
    }

    
//     /**
//      * Set level
//      *
//      * @param \App\Entity\Level $level
//      *
//      * @return Event
//      */
//     public function setLevel(\App\Entity\Level $level = null)
//     {
//         $this->level = $level;
// 
//         return $this;
//     }
// 
//     /**
//      * Get level
//      *
//      * @return \App\Entity\Level
//      */
//     public function getLevel()
//     {
//         return $this->level;
//     }
//     
//     /**
//      * Get level id
//      *
//      * @return \App\Entity\Level
//      */
//     public function getLevelId()
//     {
//         return $this->level->getId();
//     }
//     
//     /**
//      * Get levels by discipline
//      *
//      * @return \App\Entity\Event
//      */    
//     public function setDisciplineLevels($disciplines_to_order = array()) {
//         foreach($disciplines_to_order as $disciplines) {
//             $this->disciplinelevels[] = $disciplines;
//         }
//         
//         return $this;
//     }
//     
//     /**
//      * Get levels by discipline
//      *
//      * @return array
//      */ 
//     public function getDisciplineLevels() {
// 
//         return $this->disciplinelevels;
//         
//     }
//     
//     /**
//      * Get list levels by discipline
//      *
//      * @return array
//      */ 
//     function getListdisciplinelevels() {
//         return $this->listdisciplinelevels;
//     }
// 
//     /**
//      * Set levels by discipline
//      * @param array
//      * @return nothing
//      */ 
//     function setListdisciplinelevels($listdisciplinelevels) {
//         $this->listdisciplinelevels = $listdisciplinelevels;
//     }
    
    /**
     * Get Masterclass description
     *
     * @return text
     */ 
    function getMcdescription() {
        return $this->mcdescription;
    }

    /**
     * Set levels by discipline
     * @param text
     * @return Event
     */ 
    function setMcdescription($mcdescription) {
        $this->mcdescription = $mcdescription;
        return $this;
    }

    /**
     * Get masterclass
     *
     * @return boolean
     */ 
    function getMasterclass() {
        return $this->masterclass;
    }

    /**
     * Set Masterclass
     * @param boolean
     * @return Event
     */ 
    function setMasterclass($masterclass) {
        $this->masterclass = $masterclass;
        return $this;
    }

    /**
     * Get note_resultat
     *
     * @return boolean
     */ 
    function getNoteResultat() {
        return $this->note_resultat;
    }

    /**
     * Set Note resultat
     * @param boolean
     * @return Event
     */ 
    function setNoteResultat($note_resultat) {
        $this->note_resultat = $note_resultat;
        return $this;
    }


    
    /**
     * Set idTarif
     *
     * @param integer $idTarif
     *
     * @return Event
     */
    public function setIdTarif($idTarif = null)
    {
        $this->id_tarif = $idTarif;

        return $this;
    }

    /**
     * Get idtarif
     * @return integer
     */ 
    public function getIdTarif()
    {
        return $this->id_tarif;
    }
    
    
    /**
     * Get level id
     *
     * @return \App\Entity\Tarif
     */
    
    function getTarif() {
        return $this->tarif;
    }
    
    
    /**
     * Set level
     *
     * @param \App\Entity\Tarif $tarif
     *
     * @return Event
     */
    public function setTarif(\App\Entity\Tarif $tarif = null)
    {
        $this->tarif = $tarif;
        return $this;
    }
    
    public function setFilesUsed($filesUsed = array()) {
        $this->filesUsed= $filesUsed;
        return $this;
    }
    
    /**
     * Get Files
     *
     * @return array
     */ 
    public function getFilesUsed() {
        return $this->filesUsed;
    }

    //: \App\Entity\Avis {
    
    function getAviss() {
        return $this->aviss;
    }
    
    function setAviss($avis) {
        $this->aviss = $avis;
        return $this;
    }
    
    function addAvis(\App\Entity\Avis $avis){
        $this->aviss[]= $avis;
        $avis->setEvent($this);
        return $this;
    }
    
    function removeAvis(\App\Entity\Avis $avis) {
        $this->aviss->removeElement($avis);
    }
    
//     /**
//      * Set image
//      *
//      * @param \App\Entity\Image $image
//      *
//      * @return Teacher
//      */
//     public function setImage(\App\Entity\Image $image = null)
//     {
//         $this->image = $image;
// 
//         return $this;
//     }
// 
//     /**
//      * Get image
//      *
//      * @return \App\Entity\Image
//      */
//     public function getImage()
//     {
//         return $this->image;
//     }

    function getInvitations() {
        return $this->invitations;
    }

    function setInvitations($invitations) {
        $this->invitations = $invitations;
    }

//     function getQcms() {
//         return $this->qcm;
//     }
// 
//     function setQcms($qcm) {
//         $this->qcm = $qcm;
//         return $this;
//     }
// 
//     
//     function getGroupes() {
//         return $this->groupes;
//     }
//     
//     function addGroupe(\App\Entity\Groupe $groupe) {
//         
//         if (!$this->groupes->contains($groupe)) {
//             $this->groupes[] = $groupe;
//         }
//     }
// 
//     function removeGroupe(\App\Entity\Groupe $groupe) {
//         $this->groupes->removeElement($groupe);
//     }
    
    function getAutorecord() {
        return $this->autorecord;
    }

    function setAutorecord($autorecord) {
        $this->autorecord = $autorecord;
        return $this;
    }

    function getWebcamsonlyformoderator() {
        return $this->webcamsonlyformoderator;
    }

    function setWebcamsonlyformoderator($webcamsonlyformoderator) {
        $this->webcamsonlyformoderator = $webcamsonlyformoderator;
        return $this;
    }
    
    function getReplayOnlyForAdmin() {
        return $this->replayonlyforadmin;
    }

    function setReplayOnlyForAdmin($replayonlyforadmin) {
        $this->replayonlyforadmin = $replayonlyforadmin;
        return $this;
    }

    function getCreneau() {
        return $this->creneau;
    }

    function setCreneau($creneau) {
        $this->creneau = $creneau;
        return $this;
    }

    /**
     * @return Collection|Teacher[]
     */
    public function getComoderator(): Collection
    {
        return $this->comoderator;
    }

    public function addComoderator(Teacher $comoderator): self
    {
        if (!$this->comoderator->contains($comoderator)) {
            $this->comoderator[] = $comoderator;
        }

        return $this;
    }

    public function removeComoderator(Teacher $comoderator): self
    {
        $this->comoderator->removeElement($comoderator);

        return $this;
    }

    /**
     * @return Collection|Share[]
     */
    public function getShares(): Collection
    {
        return $this->shares;
    }

    public function addShare(Share $share): self
    {
        if (!$this->shares->contains($share)) {
            $this->shares[] = $share;
            $share->addEvent($this);
        }

        return $this;
    }

    public function removeShare(Share $share): self
    {
        if ($this->shares->removeElement($share)) {
            $share->removeEvent($this);
        }

        return $this;
    }

    
    public function getJob(): ?bool
    {
        return $this->job;
    }

    public function setJob(bool $job): self
    {
        $this->job = $job;

        return $this;
    }

    public function getJobstart(): ?\DateTimeInterface
    {
        return $this->jobstart;
    }

    public function setJobstart(?\DateTimeInterface $jobstart): self
    {
        $this->jobstart = $jobstart;

        return $this;
    }

    public function getJobend(): ?\DateTimeInterface
    {
        return $this->jobend;
    }

    public function setJobend(?\DateTimeInterface $jobend): self
    {
        $this->jobend = $jobend;

        return $this;
    }

    public function getLastUpdate(): ?\DateTimeInterface
    {
        return $this->lastUpdate;
    }

    public function setLastUpdate(?\DateTimeInterface $lastUpdate): self
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }

//     public function getUserUpdate(): ?User
//     {
//         return $this->userUpdate;
//     }
// 
//     public function setUserUpdate(?User $userUpdate): self
//     {
//         $this->userUpdate = $userUpdate;
// 
//         return $this;
//     }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(?string $externalId): static
    {
        $this->externalId = $externalId;

        return $this;
    }

    public function __get($prop)
    {
        return $this->$prop;
    }

    public function __isset($prop) : bool
    {
        return isset($this->$prop);
    }

    public function getSignature()
    {
        return $this->signature;
    }

    public function setSignature($signature): static
    {
        $this->signature = $signature;

        return $this;
    }

    public function isCertif(): ?bool
    {
        return $this->certif;
    }

    public function setCertif(bool $certif): static
    {
        $this->certif = $certif;

        return $this;
    }

    public function getSignaturetime(): ?\DateTimeInterface
    {
        return $this->signaturetime;
    }

    public function setSignaturetime(?\DateTimeInterface $signaturetime): static
    {
        $this->signaturetime = $signaturetime;

        return $this;
    }

}
