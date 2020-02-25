<?php

namespace OpportuniteBundle\Entity;
use Symfony\Component\Validator\Validator as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Validator\ValidatorInterface;
/**
 * opportunite
 *
 * @ORM\Table(name="opportunite")
 * @ORM\Entity(repositoryClass="OpportuniteBundle\Repository\opportuniteRepository")
 */
class opportunite
{
    /**
     * @ORM\ManyToOne(targetEntity="categorie")
     * @ORM\JoinColumn(name="categorie_id",referencedColumnName="id")
     */
    private $categorie;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="addresse", type="string", length=255)
     */
    private $addresse;
    /**
     * @var etat
     * @ORM\Column(name="etat", type="boolean", nullable=true, options={"default":true})
     */
    protected $etat;

    /**
     * @var int
     * @ORM\Column(name="nb_place", type="integer",nullable = true)
     */
    private $nbPlace;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     * @ORM\Column(name="description_opportunite", type="string", length=255)
     */
    private $descriptionOpportunite;


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
     * Set addresse
     *
     * @param string $addresse
     *
     * @return opportunite
     */
    public function setAddresse($addresse)
    {
        $this->addresse = $addresse;

        return $this;
    }

    /**
     * Get addresse
     *
     * @return string
     */
    public function getAddresse()
    {
        return $this->addresse;
    }

    /**
     * Set nbPlace
     *
     * @param integer $nbPlace
     *
     * @return opportunite
     */
    public function setNbPlace($nbPlace)
    {
        $this->nbPlace = $nbPlace;

        return $this;
    }

    /**
     * Get nbPlace
     *
     * @return int
     */
    public function getNbPlace()
    {
        return $this->nbPlace;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return opportunite
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return opportunite
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set descriptionOpportunite
     *
     * @param string $descriptionOpportunite
     *
     * @return opportunite
     */
    public function setDescriptionOpportunite($descriptionOpportunite)
    {
        $this->descriptionOpportunite = $descriptionOpportunite;

        return $this;
    }

    /**
     * Get descriptionOpportunite
     *
     * @return string
     */
    public function getDescriptionOpportunite()
    {
        return $this->descriptionOpportunite;
    }

    /**
     * @return mixed
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param mixed $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }

    /**
     * @return etat
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param etat $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

}

