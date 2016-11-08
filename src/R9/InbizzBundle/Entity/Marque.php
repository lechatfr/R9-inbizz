<?php

namespace R9\InbizzBundle\Entity;

use R9\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Marque
 *
 * @ORM\Table(name="r9_marque")
 * @ORM\Entity(repositoryClass="R9\InbizzBundle\Repository\MarqueRepository")
 */
class Marque
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="R9\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    
    /**
    * @ORM\OneToMany(targetEntity="R9\InbizzBundle\Entity\Contact", mappedBy="marque")
    */
    private $contacts; // Notez le « s », une annonce est liée à plusieurs candidatures

    /**
     * @ORM\OneToOne(targetEntity="R9\InbizzBundle\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $image;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="255")
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity="R9\InbizzBundle\Entity\Marquestatut")
     * @ORM\JoinColumn(nullable=true)
     */
    private $marquestatut;
    
    /**
     * @ORM\ManyToOne(targetEntity="R9\InbizzBundle\Entity\Marqueetat")
     * @ORM\JoinColumn(nullable=true)
     */
    private $marqueetat;
    
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="secteurdactivite", type="string", length=255, nullable=true)
     */
    private $secteurdactivite;

    /**
     * @var string
     *
     * @ORM\Column(name="chiffredaffaire", type="string", length=255, nullable=true)
     */
    private $chiffredaffaire;

    /**
     * @var string
     *
     * @ORM\Column(name="nombredesalarie", type="string", length=255, nullable=true)
     */
    private $nombredesalarie;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="adressecomplement", type="string", length=255, nullable=true)
     */
    private $adressecomplement;

    /**
     * @var string
     *
     * @ORM\Column(name="codepostal", type="string", length=255, nullable=true)
     */
    private $codepostal;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=255, nullable=true)
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="web", type="string", length=255, nullable=true)
     */
    private $web;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter", type="string", length=255, nullable=true)
     */
    private $twitter;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", length=255, nullable=true)
     */
    private $facebook;
    
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Marque
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Marque
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set secteurdactivite
     *
     * @param string $secteurdactivite
     *
     * @return Marque
     */
    public function setSecteurdactivite($secteurdactivite)
    {
        $this->secteurdactivite = $secteurdactivite;

        return $this;
    }

    /**
     * Get secteurdactivite
     *
     * @return string
     */
    public function getSecteurdactivite()
    {
        return $this->secteurdactivite;
    }

    /**
     * Set chiffredaffaire
     *
     * @param string $chiffredaffaire
     *
     * @return Marque
     */
    public function setChiffredaffaire($chiffredaffaire)
    {
        $this->chiffredaffaire = $chiffredaffaire;

        return $this;
    }

    /**
     * Get chiffredaffaire
     *
     * @return string
     */
    public function getChiffredaffaire()
    {
        return $this->chiffredaffaire;
    }

    /**
     * Set nombredesalarie
     *
     * @param string $nombredesalarie
     *
     * @return Marque
     */
    public function setNombredesalarie($nombredesalarie)
    {
        $this->nombredesalarie = $nombredesalarie;

        return $this;
    }

    /**
     * Get nombredesalarie
     *
     * @return string
     */
    public function getNombredesalarie()
    {
        return $this->nombredesalarie;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Marque
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set adressecomplement
     *
     * @param string $adressecomplement
     *
     * @return Marque
     */
    public function setAdressecomplement($adressecomplement)
    {
        $this->adressecomplement = $adressecomplement;

        return $this;
    }

    /**
     * Get adressecomplement
     *
     * @return string
     */
    public function getAdressecomplement()
    {
        return $this->adressecomplement;
    }

    /**
     * Set codepostal
     *
     * @param string $codepostal
     *
     * @return Marque
     */
    public function setCodepostal($codepostal)
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    /**
     * Get codepostal
     *
     * @return string
     */
    public function getCodepostal()
    {
        return $this->codepostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Marque
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set pays
     *
     * @param string $pays
     *
     * @return Marque
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
     * Set web
     *
     * @param string $web
     *
     * @return Marque
     */
    public function setWeb($web)
    {
        $this->web = $web;

        return $this;
    }

    /**
     * Get web
     *
     * @return string
     */
    public function getWeb()
    {
        return $this->web;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     *
     * @return Marque
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     *
     * @return Marque
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set image
     *
     * @param \R9\InbizzBundle\Entity\Image $image
     *
     * @return Marque
     */
    public function setImage(\R9\InbizzBundle\Entity\Image $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \R9\InbizzBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set marquestatut
     *
     * @param \R9\InbizzBundle\Entity\Marquestatut $marquestatut
     *
     * @return Marque
     */
    public function setMarquestatut(\R9\InbizzBundle\Entity\Marquestatut $marquestatut)
    {
        $this->marquestatut = $marquestatut;

        return $this;
    }

    /**
     * Get marquestatut
     *
     * @return \R9\InbizzBundle\Entity\Marquestatut
     */
    public function getMarquestatut()
    {
        return $this->marquestatut;
    }

    /**
     * Set marqueetat
     *
     * @param \R9\InbizzBundle\Entity\Marqueetat $marqueetat
     *
     * @return Marque
     */
    public function setMarqueetat(\R9\InbizzBundle\Entity\Marqueetat $marqueetat)
    {
        $this->marqueetat = $marqueetat;

        return $this;
    }

    /**
     * Get marqueetat
     *
     * @return \R9\InbizzBundle\Entity\Marqueetat
     */
    public function getMarqueetat()
    {
        return $this->marqueetat;
    }

    /**
     * Set user
     *
     * @param \R9\UserBundle\Entity\User $user
     *
     * @return Marque
     */
    public function setUser(\R9\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \R9\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
