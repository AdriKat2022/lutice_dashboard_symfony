<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Teacher
 */
#[ORM\Table(name: 'teacher')]
// #[ORM\Index(name: 'IDX_B0F6A6D53DA5256D', columns: ['image_id'])]
// #[ORM\Index(name: 'IDX_B0F6A6D5B38A0D28', columns: ['academie_id'])]
// #[ORM\Index(name: 'IDX_B0F6A6D56BF700BD', columns: ['status_id'])]
#[ORM\UniqueConstraint(name: 'UNIQ_B0F6A6D5F37DE0A4', columns: ['customurl'])]
#[ORM\UniqueConstraint(name: 'UNIQ_B0F6A6D54A2C17E9', columns: ['mail_academique'])]
#[ORM\UniqueConstraint(name: 'UNIQ_B0F6A6D526E94372', columns: ['siret'])]
// #[ORM\UniqueConstraint(name: 'UNIQ_B0F6A6D5A76ED395', columns: ['user_id'])]
#[ORM\Entity(repositoryClass: '\App\Repository\TeacherRepository')]
class Teacher
{
    /**
     * @var int
     */
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'first_name', type: 'string', length: 255, nullable: true)]
    private $firstName;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'last_name', type: 'string', length: 255, nullable: true)]
    private $lastName;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'beneficiaire', type: 'string', length: 255, nullable: true)]
    private $beneficiaire;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'adresse_beneficiaire', type: 'string', length: 255, nullable: true)]
    private $adresse_beneficiaire;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'iban', type: 'string', length: 30, nullable: true)]
    private $iban;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'bicswift', type: 'string', length: 11, nullable: true)]
    private $bicswift;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'mail_academique', type: 'string', length: 100, nullable: true)]
    private $mail_academique;
    
    /**
     * @var string|null
     */
    #[ORM\Column(name: 'siret', type: 'string', length: 255, nullable: true)]
    private $siret;

    /**
     * @var bool
     */
    #[ORM\Column(name: 'valide', type: 'boolean', nullable: false)]
    private $valide;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'pricing', type: 'integer', nullable: true)]
    private $pricing;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'address', type: 'string', length: 255, nullable: true)]
    private $address;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'codepostal', type: 'string', length: 15, nullable: true)]
    private $codepostal;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'city', type: 'string', length: 40, nullable: true)]
    private $city;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'pays', type: 'string', length: 40, nullable: true)]
    private $pays;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'titre_presentation', type: 'string', length: 255, nullable: true)]
    private $titre_presentation;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'presentation', type: 'text', length: 0, nullable: true)]
    private $presentation;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'experience', type: 'text', length: 0, nullable: true)]
    private $experience;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'cv', type: 'text', length: 0, nullable: true)]
    private $cv;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'lien_fb', type: 'string', length: 100, nullable: true)]
    private $lien_fb;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'lien_twitter', type: 'string', length: 100, nullable: true)]
    private $lien_twitter;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'lien_linkedin', type: 'string', length: 100, nullable: true)]
    private $lien_linkedin;
    
    /**
     * @var string|null
     */
    #[ORM\Column(name: 'customurl', type: 'string', length: 50, nullable: true)]
    private $customurl;
    
//     /**
//      * @var \App\Entity\User
//      */
//     #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
//     #[ORM\OneToOne(targetEntity: '\App\Entity\User', cascade: ['all'])]
//     private $user;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    #[ORM\OneToMany(targetEntity: '\App\Entity\Event', mappedBy: 'teacher')]
    private $event;

//     /**
//      * @var \Doctrine\Common\Collections\Collection
//      */
//     #[ORM\OneToMany(targetEntity: '\App\Entity\Availability', mappedBy: 'teacher')]
//     private $availabilities;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $avisRecus;
    
//     /**
//      * @var \Doctrine\Common\Collections\Collection
//      */
//     #[ORM\OneToMany(targetEntity: '\App\Entity\Avis', mappedBy: 'teacher')]
//     private $avisRecu;
    
//     /**
//      * @var \App\Entity\Image
//      */
//     #[ORM\JoinColumn(name: 'image_id', referencedColumnName: 'id', nullable: true)]
//     #[ORM\ManyToOne(targetEntity: '\App\Entity\Image', cascade: ['all'])]
//     private $image;
// 
//     /**
//      * @var \App\Entity\Status
//      */
//     #[ORM\JoinColumn(name: 'status_id', referencedColumnName: 'id')]
//     #[ORM\ManyToOne(targetEntity: '\App\Entity\Status')]
//     private $status;
//     
//     /**
//      * @var \Doctrine\Common\Collections\Collection
//      */
//     #[ORM\ManyToMany(targetEntity: '\App\Entity\School', mappedBy: 'teachers')]
//     private $schools;
    
    
//    private $payment;
//     /**
//      * @var \Doctrine\Common\Collections\Collection
//      */
//     #[ORM\JoinTable(name: 'teacher_discipline')]
//     #[ORM\JoinColumn(name: 'teachers_id', referencedColumnName: 'id')]
//     #[ORM\InverseJoinColumn(name: 'disciplines_id', referencedColumnName: 'id')]
//     #[ORM\ManyToMany(targetEntity: '\App\Entity\Discipline', inversedBy: 'teachers')]
//     private $disciplines;
//     
//     
//     /**
//      * @var \App\Entity\Academie
//      */
//     #[ORM\JoinColumn(name: 'academie_id', referencedColumnName: 'id', nullable: true)]
//     #[ORM\ManyToOne(targetEntity: '\App\Entity\Academie')]
//     private $academie;
    
    // A VERIFIER 
     /**
     * @var string
     */
    private $num_identification; // A VIRER ?
    
    /*
     * @var string 
     */
    private $matieres;
    
    /**
     * @var string|null
     */
    private $email;
    
    /**
     * @var string|null
     */

    private $plainpassword;
    
    /*
     * @var int
     */
    private $publicpricing;

    #[ORM\OneToMany(targetEntity: EventTeacher::class, mappedBy: 'teacher')]
    private $coevent;

    #[ORM\Column(nullable: true)]
    private ?int $externalId = null; 

// A VIRER ?
   
    const EDUC_NAT = 'Education Nationale';
    const INDE = 'Indépendant';
    const PRO = 'Professionnel';

    
    public function __construct()
    {
        $this->event = new ArrayCollection();
//         $this->availabilities = new ArrayCollection();
//         $this->avisRecus = new ArrayCollection();
//         $this->schools = new ArrayCollection();
//         $this->matieres = new ArrayCollection();
//         $this->disciplines = new ArrayCollection();
//         $this->coevent = new ArrayCollection();
    }

    public function __toString() {

        return (string)$this->firstName.' '.$this->lastName;
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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Teacher
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Teacher
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set beneficiaire
     *
     * @param string $beneficiaire
     *
     * @return Teacher
     */
    public function setBeneficiaire($beneficiaire)
    {
        $this->beneficiaire = $beneficiaire;

        return $this;
    }

    /**
     * Get beneficiaire
     *
     * @return string
     */
    public function getBeneficiaire()
    {
        return $this->beneficiaire;
    }

    /**
     * Set adresseBeneficiaire
     *
     * @param string $adresseBeneficiaire
     *
     * @return Teacher
     */
    public function setAdresseBeneficiaire($adresseBeneficiaire)
    {
        $this->adresse_beneficiaire = $adresseBeneficiaire;

        return $this;
    }

    /**
     * Get adresseBeneficiaire
     *
     * @return string
     */
    public function getAdresseBeneficiaire()
    {
        return $this->adresse_beneficiaire;
    }

    /**
     * Set iban
     *
     * @param string $iban
     *
     * @return Teacher
     */
    public function setIban($iban)
    {
        $this->iban = $iban;

        return $this;
    }

    /**
     * Get iban
     *
     * @return string
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * Set bicswift
     *
     * @param string $bicswift
     *
     * @return Teacher
     */
    public function setBicswift($bicswift)
    {
        $this->bicswift = $bicswift;

        return $this;
    }

    /**
     * Get bicswift
     *
     * @return string
     */
    public function getBicswift()
    {
        return $this->bicswift;
    }

    /**
     * Set numIdentification
     *
     * @param string $numIdentification
     *
     * @return Teacher
     */
    public function setNumIdentification($numIdentification)
    {
        $this->num_identification = $numIdentification;

        return $this;
    }

    /**
     * Get numIdentification
     *
     * @return string
     */
    public function getNumIdentification()
    {
        return $this->num_identification;
    }

    /**
     * Set valide
     *
     * @param boolean $valide
     *
     * @return Teacher
     */
    public function setValide($valide)
    {
        $this->valide = $valide;

        return $this;
    }

    /**
     * Get valide
     *
     * @return boolean
     */
    public function getValide()
    {
        return $this->valide;
    }

    /**
     * Set pricing
     *
     * @param integer $pricing
     *
     * @return Teacher
     */
    public function setPricing($pricing)
    {
        $this->pricing = $pricing;

        return $this;
    }

    /**
     * Get pricing
     *
     * @return integer
     */
    public function getPricing()
    {
        return $this->pricing;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Teacher
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }
    
    /**
     * Get Publicpricing
     *
     * @return int
     */
    function getPublicpricing() {
        return $this->publicpricing;
    }

     /**
     * Set Publicpricing
     *
     * @param int $publicpricing
     *
     * @return Teacher
     */
    
    function setPublicpricing($publicpricing) {
        $this->publicpricing = $publicpricing;
        return $this;
    }

        

    /**
     * Set codepostal
     *
     * @param integer $codepostal
     *
     * @return Teacher
     */
    public function setCodepostal($codepostal)
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    /**
     * Get codepostal
     *
     * @return integer
     */
    public function getCodepostal()
    {
        return $this->codepostal;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Teacher
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set pays
     *
     * @param string $pays
     *
     * @return Teacher
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set titrePresentation
     *
     * @param string $titrePresentation
     *
     * @return Teacher
     */
    public function setTitrePresentation($titrePresentation)
    {
        $this->titre_presentation = $titrePresentation;

        return $this;
    }

    /**
     * Get titrePresentation
     *
     * @return string
     */
    public function getTitrePresentation()
    {
        return $this->titre_presentation;
    }

    /**
     * Set presentation
     *
     * @param string $presentation
     *
     * @return Teacher
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * Get presentation
     *
     * @return string
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * Set experience
     *
     * @param string $experience
     *
     * @return Teacher
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;

        return $this;
    }

    /**
     * Get experience
     *
     * @return string
     */
    function getExperience()
    {
        return $this->experience;
    }

    /**
     * Set cv
     *
     * @param string $cv
     *
     * @return Teacher
     */
    function setCv($cv)
    {
        $this->cv = $cv;

        return $this;
    }

    /**
     * Get cv
     *
     * @return string
     */
    function getCv()
    {
        return $this->cv;
    }

    /**
     * Set lienFb
     *
     * @param string $lienFb
     *
     * @return Teacher
     */
    function setLienFb($lienFb)
    {
        $this->lien_fb = $lienFb;

        return $this;
    }

    /**
     * Get lienFb
     *
     * @return string
     */
    function getLienFb()
    {
        return $this->lien_fb;
    }

    /**
     * Set lienTwitter
     *
     * @param string $lienTwitter
     *
     * @return Teacher
     */
    function setLienTwitter($lienTwitter)
    {
        $this->lien_twitter = $lienTwitter;

        return $this;
    }

    /**
     * Get lienTwitter
     *
     * @return string
     */
    function getLienTwitter()
    {
        return $this->lien_twitter;
    }

    /**
     * Set lienLinkedin
     *
     * @param string $lienLinkedin
     *
     * @return Teacher
     */
    function setLienLinkedin($lienLinkedin)
    {
        $this->lien_linkedin = $lienLinkedin;

        return $this;
    }

    /**
     * Get lienLinkedin
     *
     * @return string
     */
    function getLienLinkedin()
    {
        return $this->lien_linkedin;
    }

    /**
     * Set user
     *
     * @param \App\Entity\User $user
     *
     * @return Teacher
     */
    function setUser(\App\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \App\Entity\User
     */
    function getUser()
    {
        return $this->user;
    }

    /**
     * Add event
     *
     * @param \App\Entity\Event $event
     *
     * @return Teacher
     */
    function addEvent(\App\Entity\Event $event)
    {
        $this->event[] = $event;

        return $this;
    }

    /**
     * Remove event
     *
     * @param \App\Entity\Event $event
     */
    function removeEvent(\App\Entity\Event $event)
    {
        $this->event->removeElement($event);
    }

    /**
     * Get event
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    function getEvent()
    {
        return $this->event;
    }

    /**
     * Get payment
     *
     * @return \Doctrine\Common\Collections\Collection
     */
//    public function getPayment()
//    {
//        return $this->payment;
//    }
    
    /**
     * Add availability
     *
     * @param \App\Entity\Availability $availability
     *
     * @return Teacher
     */
    function addAvailability(\App\Entity\Availability $availability)
    {
        $this->availabilities[] = $availability;

        return $this;
    }

    /**
     * Remove availability
     *
     * @param \App\Entity\Availability $availability
     */
    function removeAvailability(\App\Entity\Availability $availability)
    {
        $this->availabilities->removeElement($availability);
    }

    /**
     * Get availabilities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    function getAvailabilities()
    {
        return $this->availabilities;
    }

    /**
     * Add avi
     *
     * @param \App\Entity\Avis $avi
     *
     * @return Teacher
     */
    function addAvis(\App\Entity\Avis $avis)
    {
        $this->avisRecus[] = $avis;

        return $this;
    }

    /**
     * Remove avi
     *
     * @param \App\Entity\Avis $avi
     */
    public function removeAvis(\App\Entity\Avis $avis)
    {
        $this->avisRecus->removeElement($avis);
    }

    /**
     * Get avis
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAvisRecu()
    {
        return $this->avisRecu;
    }

    /**
     * Set image
     *
     * @param \App\Entity\Image $image
     *
     * @return Teacher
     */
    public function setImage(\App\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \App\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set status
     *
     * @param \App\Entity\Status $status
     *
     * @return Teacher
     */
    public function setStatus(\App\Entity\Status $status = null)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get status
     *
     * @return \App\Entity\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add school
     *
     * @param \App\Entity\School $school
     *
     * @return Teacher
     */
    public function addSchool(\App\Entity\School $school)
    {
        $this->schools[] = $school;

        return $this;
    }

    /**
     * Remove school
     *
     * @param \App\Entity\School $school
     */
    public function removeSchool(\App\Entity\School $school)
    {
        $this->schools->removeElement($school);
    }

    /**
     * Get schools
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSchools()
    {
        return $this->schools;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */


    /**
     * Add matiere
     *
     * @param \App\Entity\TeacherDiscipline $matiere
     *
     * @return Teacher
     */
//    public function addMatiere(\App\Entity\Discipline $matiere)
//    {
//        $this->matieres[] = $matiere;
//
//        return $this;
//    }

    /**
     * Remove matiere
     *
     * @param \App\Entity\TeacherDiscipline $matiere
     */
//    public function removeMatiere(\App\Entity\Discipline $matiere)
//    {
//        $this->matieres->removeElement($matiere);
//    }

    /**
     * Get matieres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
//    public function getMatieres()
//    {
//        return $this->matieres;
//    }
    
    
    /**
     * Add discipline
     *
     * @param \App\Entity\discipline $discipline
     *
     * @return Teacher
     */
    function addDiscipline(Discipline $discipline)
    {
        if ($this->disciplines->contains($discipline)) {
            return;
        }
        $this->disciplines[] = $discipline;
        return $this;
    }

    /**
     * Remove matiere
     *
     * @param \App\Entity\TeacherDiscipline $discipline
     */
    function removeDiscipline(Discipline $discipline)
    {
        $this->disciplines->removeElement($discipline);
    }

    /**
     * Get disciplines
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    function getDisciplines()
    {
        return $this->disciplines;
    }
    
    /**
     * Set mailAcademique
     *
     * @param string $mailAcademique
     *
     * @return Teacher
     */
    function setMailAcademique($mailAcademique)
    {
        $this->mail_academique = $mailAcademique;

        return $this;
    }

    /**
     * Get mailAcademique
     *
     * @return string
     */
    function getMailAcademique()
    {
        return $this->mail_academique;
    }

    /**
     * Set siret
     *
     * @param string $siret
     *
     * @return Teacher
     */
    function setSiret($siret)
    {
        $this->siret = $siret;

        return $this;
    }

    /**
     * Get siret
     *
     * @return string
     */
    function getSiret()
    {
        return $this->siret;
    }
    
//     /**
//      * Set academie
//      *
//      * @param \App\Entity\Academie $academie
//      *
//      * @return Teacher
//      */
//     function setAcademie(\App\Entity\Academie $academie = null)
//     {
//         $this->academie = $academie;
// 
//         return $this;
//     }
// 
//     /**
//      * Get academie
//      *
//      * @return \App\Entity\Academie
//      */
//     function getAcademie()
//     {
//         return $this->academie;
//     }
    
    
    /**
     * Set customurl
     *
     * @param string $customurl
     *
     * @return Teacher
     */
    
    function setCustomurl($customurl) {
        $this->customurl = $customurl;
        return $this;
    }
        
    /**
     * Get customurl.{domain}
     *
     * @return string
     */
    function getCustomurl() {
        return $this->customurl;
    }

    
    function getFullName() {
        return $this->lastName.' '.$this->firstName;
    }
    
    function getEnabled() {
        if(!is_null($this->user)) {
            return $this->user->getEnabled();
        } else {
            return false;
        }
    }

    function setEmail($eMail) {
        $this->email = $eMail;
        return $this;
    }

    function setPlainpassword($plainPassword) {
        $this->plainpassword = $plainPassword;
        return $this;
    }

    function getEmail() {
        return $this->email;
    }
    
    function getPlainpassword() {
        return $this->plainpassword;
    }

    /**
     * @return Collection|Event[]
     */
    function getCoevent(): Collection
    {
        return $this->coevent;
    }

    function addCoevent(Event $coevent): self
    {
        if (!$this->coevent->contains($coevent)) {
            $this->coevent[] = $coevent;
            $coevent->addComoderator($this);
        }

        return $this;
    }

    function removeCoevent(Event $coevent): self
    {
        if ($this->coevent->removeElement($coevent)) {
            $coevent->removeComoderator($this);
        }

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

    public function getExternalId(): ?int
    {
        return $this->externalId;
    }

    public function setExternalId(?int $externalId): static
    {
        $this->externalId = $externalId;

        return $this;
    }
    
}
