<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Meeting
 */
#[ORM\Table(name: 'meeting')]
#[ORM\UniqueConstraint(name: 'UNIQ_F515E13971F7E88B', columns: ['event_id'])]
#[ORM\Entity(repositoryClass: '\App\Repository\MeetingRepository')]
class Meeting
{

    /**
     * @var int
     */
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;

    /**
     * @var string
     */
    #[ORM\Column(name: 'meeting_id', type: 'string', length: 100, nullable: false)]
    private $meetingId;

    /**
     * @var string
     */
    #[ORM\Column(name: 'school_password', type: 'string', length: 255, nullable: false)]
    private $schoolPassword;

    /**
     * @var string
     */
    #[ORM\Column(name: 'teacher_password', type: 'string', length: 255, nullable: false)]
    private $teacherPassword;

    /**
     * @var string
     */
    #[ORM\Column(name: 'duration', type: 'string', length: 255, nullable: false)]
    private $duration;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'record_id', type: 'string', length: 255, nullable: true)]
    private $recordId;

    /**
     * @var string
     */
    #[ORM\Column(name: 'meeting_name', type: 'string', length: 255, nullable: false)]
    private $meetingName;
    
    /**
     * @var \DateTime|null
     */
    #[ORM\Column(name: 'start_time', type: 'datetime', nullable: true)]
    private $startTime;
    
    /**
     * @var \DateTime|null
     */
    #[ORM\Column(name: 'end_time', type: 'datetime', nullable: true)]
    private $endTime;
    
    /**
     * @var int|null
     */
    #[ORM\Column(name: 'views', type: 'integer', nullable: true)]
    private $views;
    
    /**
     * @var string
     */
    #[ORM\Column(name: 'reason', type: 'string', length: 255, nullable: true)]
    private $reason;
    
    /**
     * @var bool
     */
    #[ORM\Column(name: 'autorecord', type: 'boolean', options: ['default' => 1])]
    private $autorecord;
    
    /**
     * @var bool 
     */
    #[ORM\Column(name: 'publish_state', type: 'boolean', options: ['default' => 1])]
    private $publishState;
    
    /**
     * @var bool
     */
    #[ORM\Column(name: 'available', type: 'boolean', options: ['default' => 0])]
    private $available;

    /**
     * @var bool
     */
    #[ORM\Column(name: 'webcamsonlyformoderator', type: 'boolean', options: ['default' => 1])]
    private $webcamsonlyformoderator;
    
    /**
     * @var \App\Entity\Event
     */
    #[ORM\JoinColumn(name: 'event_id', referencedColumnName: 'id')]
    #[ORM\OneToOne(targetEntity: '\App\Entity\Event', inversedBy: 'meeting')]
    private $event;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     */
    private $events;

    #[ORM\Column(options:['default' => 0])]
    private ?bool $replayOnlyForAdmin = false;

    #[ORM\Column(options:['default' => 0])]
    private ?bool $dashboardReady = false;

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

    
    /**
         * Constructor
     */
    public function __construct()
    {
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set meetingId
     *
     * @param string $meetingId
     *
     * @return Meeting
     */
    public function setMeetingId($meetingId)
    {
        $this->meetingId = $meetingId;

        return $this;
    }

    /**
     * Get meetingId
     *
     * @return string
     */
    public function getMeetingId()
    {
        return $this->meetingId;
    }

    /**
     * Set recordId
     *
     * @param string $recordId
     *
     * @return Meeting
     */
    public function setRecordId($recordId)
    {
        $this->recordId = $recordId;

        return $this;
    }

    /**
     * Get recordId
     *
     * @return string
     */
    public function getRecordId()
    {
        return $this->recordId;
    }    
    
    /**
     * Set schoolPassword
     *
     * @param string $schoolPassword
     *
     * @return Meeting
     */
    public function setSchoolPassword($schoolPassword)
    {
        $this->schoolPassword = $schoolPassword;

        return $this;
    }

    /**
     * Get schoolPassword
     *
     * @return string
     */
    public function getSchoolPassword()
    {
        return $this->schoolPassword;
    }

    /**
     * Set teacherPassword
     *
     * @param string $teacherPassword
     *
     * @return Meeting
     */
    public function setTeacherPassword($teacherPassword)
    {
        $this->teacherPassword = $teacherPassword;

        return $this;
    }

    /**
     * Get teacherPassword
     *
     * @return string
     */
    public function getTeacherPassword()
    {
        return $this->teacherPassword;
    }

    /**
     * Set duration
     *
     * @param string $duration
     *
     * @return Meeting
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return string
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set event
     *
     * @param \App\Entity\Event $event
     *
     * @return Meeting
     */
    public function setEvent(\App\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \App\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }
    
    /*
     * Get Meeting Name
     * @return string
     */
    
    function getMeetingName() {
        return $this->meetingName;
    }

    /*
     * Set Meeting Name
     * @return Meeting
     */
    
    function setMeetingName($meetingName) {
        $this->meetingName = $meetingName;
        return $this;
    }
    
    
    function getStartTime() {
        return $this->startTime;
    }

    function getEndTime() {
        return $this->endTime;
    }

    function getViews() {
        return $this->views;
    }

    function setStartTime($startTime) {
        $this->startTime = $startTime;
        return $this;
    }

    function setEndTime($endTime) {
        $this->endTime = $endTime;
        return $this;
    }

    function setViews($views) {
        $this->views = $views;
        return $this;
    }
    public function __toString() {
    return $this->meetingName;
    }
    
       
    public function replayUrl() {
        dd($this);
        return getenv('replay_URL').'?meetingId='.$this->getRecordId();
    }
    

    function getReason() {
        return $this->reason;
    }

    function setReason($reason) {
        $this->reason = $reason;
        return $this;
    }

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

    function getAvailable() {
        return $this->available;
    }

    function setAvailable($available) {
        $this->available = $available;
    }

        
    function getPublishState() {
        return $this->publishState;
    }

    function setPublishState($publishState) {
        $this->publishState = $publishState;
    }

    public function isReplayOnlyForAdmin(): ?bool
    {
        return $this->replayOnlyForAdmin;
    }

    public function setReplayOnlyForAdmin(bool $replayOnlyForAdmin): self
    {
        $this->replayOnlyForAdmin = $replayOnlyForAdmin;

        return $this;
    }

    public function isDashboardReady(): ?bool
    {
        return $this->dashboardReady;
    }

    public function setDashboardReady(bool $dashboardReady): static
    {
        $this->dashboardReady = $dashboardReady;

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

    public function getTalkTime(): ?int
    {
        return $this->talkTime;
    }

    public function setTalkTime(?int $talkTime): static
    {
        $this->talkTime = $talkTime;

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

    public function getMessageCount(): ?int
    {
        return $this->messageCount;
    }

    public function setMessageCount(?int $messageCount): static
    {
        $this->messageCount = $messageCount;

        return $this;
    }

    public function getConnectionCount(): ?int
    {
        return $this->connectionCount;
    }

    public function setConnectionCount(?int $connectionCount): static
    {
        $this->connectionCount = $connectionCount;

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
}
