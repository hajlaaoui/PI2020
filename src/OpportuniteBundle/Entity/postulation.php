<?php

namespace OpportuniteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * postulation
 *
 * @ORM\Table(name="postulation")
 * @ORM\Entity(repositoryClass="OpportuniteBundle\Repository\postulationRepository")
 */
class postulation
{
    /**
     * @ORM\ManyToOne(targetEntity="opportunite")
     * @ORM\JoinColumn(name="opportunite_id",referencedColumnName="id")
     */
    private $opportunite;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    private $fos_user;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     *
     */
    public function __construct()
    {
        $this->setDate(new \DateTime("now"));
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return postulation
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getOpportunite()
    {
        return $this->opportunite;
    }

    /**
     * @param mixed $opportunite
     */
    public function setOpportunite($opportunite)
    {
        $this->opportunite = $opportunite;
    }

    /**
     * @return mixed
     */
    public function getFosUser()
    {
        return $this->fos_user;
    }

    /**
     * @param mixed $fos_user
     */
    public function setFosUser($fos_user)
    {
        $this->fos_user = $fos_user;
    }

}

