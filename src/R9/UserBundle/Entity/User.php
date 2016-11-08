<?php
// src/R9/UserBundle/Entity/User.php

namespace R9\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Table(name="r9_user")
 * @ORM\Entity(repositoryClass="R9\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
  /**
   * @var int
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;
    
    /** 
    * @ORM\Column(name="google_id", type="string", length=255, nullable=true) 
    */
    protected $googleId;
    
    /** 
    * @ORM\Column(name="google_access_token", type="string", length=255, nullable=true) 
    */
    protected $google_access_token;

    /**
     * @ORM\OneToOne(targetEntity="R9\InbizzBundle\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $image;
    
    /**
   * @var string
   *
   * @ORM\Column(name="nom", type="string", length=255, nullable=true)
   */
  private $nom;

    /**
   * @var string
   *
   * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
   */
  private $prenom;

    /**
   * @var string
   *
   * @ORM\Column(name="agence", type="string", length=255, nullable=true)
   */
  private $agence;

    /**
   * @var string
   *
   * @ORM\Column(name="facebook", type="string", length=255, nullable=true)
   */
  private $facebook;

    /**
   * @var string
   *
   * @ORM\Column(name="tel", type="string", length=255, nullable=true)
   */
  private $tel;

    /**
   * @var string
   *
   * @ORM\Column(name="connaissancessectorielles", type="string", length=255, nullable=true)
   */
  private $connaissancessectorielles;

    /**
   * @var string
   *
   * @ORM\Column(name="competencesmetier", type="string", length=255, nullable=true)
   */
  private $competencesmetier;

    /**
   * @var string
   *
   * @ORM\Column(name="interets", type="string", length=255, nullable=true)
   */
  private $interets;


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set agence
     *
     * @param string $agence
     *
     * @return User
     */
    public function setAgence($agence)
    {
        $this->agence = $agence;

        return $this;
    }

    /**
     * Get agence
     *
     * @return string
     */
    public function getAgence()
    {
        return $this->agence;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return User
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
     * Set facebook
     *
     * @param string $facebook
     *
     * @return User
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
     * Set tel
     *
     * @param string $tel
     *
     * @return User
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set connaissancessectorielles
     *
     * @param string $connaissancessectorielles
     *
     * @return User
     */
    public function setConnaissancessectorielles($connaissancessectorielles)
    {
        $this->connaissancessectorielles = $connaissancessectorielles;

        return $this;
    }

    /**
     * Get connaissancessectorielles
     *
     * @return string
     */
    public function getConnaissancessectorielles()
    {
        return $this->connaissancessectorielles;
    }

    /**
     * Set competencesmetier
     *
     * @param string $competencesmetier
     *
     * @return User
     */
    public function setCompetencesmetier($competencesmetier)
    {
        $this->competencesmetier = $competencesmetier;

        return $this;
    }

    /**
     * Get competencesmetier
     *
     * @return string
     */
    public function getCompetencesmetier()
    {
        return $this->competencesmetier;
    }

    /**
     * Set interets
     *
     * @param string $interets
     *
     * @return User
     */
    public function setInterets($interets)
    {
        $this->interets = $interets;

        return $this;
    }

    /**
     * Get interets
     *
     * @return string
     */
    public function getInterets()
    {
        return $this->interets;
    }

    /**
     * Set googleId
     *
     * @param string $googleId
     *
     * @return User
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;

        return $this;
    }

    /**
     * Get googleId
     *
     * @return string
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * Set googleAccessToken
     *
     * @param string $googleAccessToken
     *
     * @return User
     */
    public function setGoogleAccessToken($googleAccessToken)
    {
        $this->google_access_token = $googleAccessToken;

        return $this;
    }

    /**
     * Get googleAccessToken
     *
     * @return string
     */
    public function getGoogleAccessToken()
    {
        return $this->google_access_token;
    }

    /**
     * Set image
     *
     * @param \R9\InbizzBundle\Entity\Image $image
     *
     * @return User
     */
    public function setImage(\R9\InbizzBundle\Entity\Image $image = null)
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
}
