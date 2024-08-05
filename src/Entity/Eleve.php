<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Eleve
 */
#[ORM\Table(name: 'eleve')]
// #[ORM\Index(name: 'IDX_ECA105F73DA5256D', columns: ['image_id'])]
// #[ORM\UniqueConstraint(name: 'UNIQ_ECA105F7A76ED395', columns: ['user_id'])]
#[ORM\Entity(repositoryClass: '\App\Repository\EleveRepository')]
class Eleve
{

    const PARTICULIER = 'Particulier';

    // GENERATED CODE
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
    #[ORM\Column(name: 'phone', type: 'string', length: 20, nullable: true)]
    private $phone;

    /**
     * @var boolean
     */
    private $valide;
    
//     /**
//      * @var int
//      */
//     #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
//     #[ORM\OneToOne(targetEntity: '\App\Entity\User', inversedBy: 'eleve', cascade: ['all'])]
//     private $user;

    /**
     * @var \App\Entity\Cours
     */
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    #[ORM\OneToMany(targetEntity: '\App\Entity\Cours', mappedBy: 'eleve', cascade: ['all'])]
    private $coursSuivis;
    
//     /**
//      * @var int
//      */
//     #[ORM\JoinColumn(name: 'image_id', referencedColumnName: 'id', nullable: true)]
//     #[ORM\ManyToOne(targetEntity: '\App\Entity\Image', cascade: ['all'])]
//     private $image;
    
//     /**
//      * @var \Doctrine\Common\Collections\Collection
//      */
//     #[ORM\JoinTable(name: 'eleve_groupe')]
//     #[ORM\JoinColumn(name: 'eleve_id', referencedColumnName: 'id')]
//     #[ORM\InverseJoinColumn(name: 'groupe_id', referencedColumnName: 'id')]
//     #[ORM\ManyToMany(targetEntity: '\App\Entity\Groupe', inversedBy: 'eleves')]
//     private $groupes;
    
//     /**
//      * @var \Doctrine\Common\Collections\Collection
//      */
//     #[ORM\JoinTable(name: 'eleve_parcours')]
//     #[ORM\JoinColumn(name: 'eleve_id', referencedColumnName: 'id')]
//     #[ORM\InverseJoinColumn(name: 'parcours_id', referencedColumnName: 'id')]
//     #[ORM\ManyToMany(targetEntity: '\App\Entity\Parcours', inversedBy: 'eleves', cascade: ['persist'])]
//     private $parcourss;
    
    /**
     * @var string|null
     */
    private $email;
    
    /**
     * @var string|null
     */

    private $plainpassword;
    
    // A VERIFIER
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $event; // A VIRER ?

    /**
     * @var \App\Entity\Groupe
     */
    private $groupe; // A VIRER ?
    
    private $listegroupe; // A VIRER ?
    
  
    /**
     * Many Eleves have Many Events.
     * @var \App\Entity\Event
     */
    private $events;

    #[ORM\Column(nullable: true)]
    private ?int $externalId = null; // A VIRER
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        //$this->events = new \Doctrine\Common\Collections\ArrayCollection();
        //$this->teachers = new \Doctrine\Common\Collections\ArrayCollection();
//         $this->coursSuivis = new \Doctrine\Common\Collections\ArrayCollection();
//         $this->listegroupe = new \Doctrine\Common\Collections\ArrayCollection();
//         $this->groupes = new \Doctrine\Common\Collections\ArrayCollection();
//         $this->parcourss = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return (string) $this->firstName.' '.$this->lastName;
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
    
    function getGroupes() {
        return $this->groupes;
    }
    
    public function addGroupe(Groupe $groupe)
    {
        
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
        }
        return $this;
    }
    /**
     * Get groupe
     *
     * @return \App\Entity\Groupe
     */
    public function getGroupe(){
        return $this->groupe;
    }
    
    function setGroupe(Groupe $groupe) {
        $this->groupe = $groupe;
    }
    /**
     * Remove groupe
     *
     * @param \AppBundle\Entity\Groupe $groupe
     */
    public function removeGroupe(Groupe $groupe)
    {
        $this->groupes->removeElement($groupe);
    }
        
    /**
     * Get Groupes
     *
     * @return array
     */ 
    public function getListeGroupe() {
        return $this->listegroupe;
    }
    
    public function setListeGroupe($listeGroupe = array()) {
        $this->listegroupe= $listeGroupe;
        return $this;
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
     * Set valide
     *
     * @param boolean $valide
     *
     * @return Eleve
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
     * Get Phone
     *
     * @return string
     */
    
    function getPhone() {
        return $this->phone;
    }

        /**
     * Set Phone
     *
     * @param string $phone
     *
     * @return Eleve
     */
    
    function setPhone($phone) {
        $this->phone = $phone;
    }

        
    /**
     * Set address
     *
     * @param string $address
     *
     * @return Eleve
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
     * Set codepostal
     *
     * @param integer $codepostal
     *
     * @return Eleve
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
     * @return Eleve
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
     * @return Eleve
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


//     /**
//      * Set user
//      *
//      * @param int $user
//      *
//      * @return Eleve
//      */
//     public function setUser(int $user = null)
//     {
//         $this->user = $user;
// 
//         return $this;
//     }
// 
//     /**
//      * Get user
//      *
//      * @return int
//      */
//     public function getUser()
//     {
//         return $this->user;
//     }


//     /**
//      * Set image
//      *
//      * @param int $image
//      *
//      * @return Eleve
//      */
//     public function setImage(int $image = null)
//     {
//         $this->image = $image;
// 
//         return $this;
//     }
// 
//     /**
//      * Get image
//      *
//      * @return int
//      */
//     public function getImage()
//     {
//         return $this->image;
//     }
    
   
    /**
     * Get events
     *
     * @return \App\Entity\Event
     */
    public function getEvents()
    {
        return $this->events;
    }


    
    function getEvent() {
        return $this->event;
    }

    function setEvent(\Doctrine\Common\Collections\Collection $event) {
        $this->event = $event;
    }
    
    function getFullName() {
        return $this->lastName.' '.$this->firstName;
    }
    
    
    /**
     * Get cours
     *
     * @return \Doctrine\Common\Collections\Collection|cours[]
     */
    
    public function getCoursSuivis()
    {
        //return array(86,88);
        return $this->coursSuivis;
    }
    
    public function addEleveCours($cours) {
        $this->cours[] = $cours;
    }
    
    public function removeEleveCours($cours) {
        $this->cours->removeElement($cours);
    }



//     public function addParcours(\App\Entity\Parcours $parcours)
//     {
//     
//         $this->parcourss[] = $parcours;
// 
//         return $this;
//     }
// 
//     public function removeParcours(\App\Entity\Parcours $parcours)
//     {
//         // Ici on utilise une méthode de l'ArrayCollection, pour supprimer la catégorie en argument
//         $this->parcourss->removeElement($parcours);
//     }
// 
//     // Notez le pluriel, on récupère une liste de catégories ici !
//     public function getParcourss()
//     {
//         return $this->parcourss;
//     }

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
