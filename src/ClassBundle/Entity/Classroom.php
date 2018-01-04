<?php

namespace ClassBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Classroom
 *
 * @ORM\Table(name="classroom")
 * @ORM\Entity(repositoryClass="ClassBundle\Repository\ClassroomRepository")
 */
class Classroom
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="nbseats", type="integer")
     */
    private $nbseats;

    /**
     * @ORM\OneToOne(targetEntity="Speaker")
     * @ORM\JoinColumn(name="speaker_id", referencedColumnName="id")
     */

    private $speaker;

    /**
     * @ORM\OneToMany(targetEntity="Seat", mappedBy="seatClass")
     */
    private $seat;

    public function __construct()
    {
       $this->speaker = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Classroom
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set nbseats
     *
     * @param integer $seat
     *
     * @return Classroom
     */
    public function setNbSeats($nbseats)
    {
        $this->nbseats = $nbseats;

        return $this;
    }

    /**
     * Get nbseats
     *
     * @return int
     */
    public function getNbSeats()
    {
        return $this->nbseats;
    }

    /**
     * Set speaker
     *
     * @param ArrayCollection $speaker
     *
     * @return Classroom
     */
    public function setSpeaker($speaker)
    {
        $this->speaker = $speaker;

        return $this;
    }

    /**
     * Get speaker
     *
     * @return ArrayCollection
     */
    public function getSpeaker()
    {
        return $this->speaker;
    }

    public function addSpeaker($speaker)
    {
      $this->speaker[] += $speaker;
    }

    /**
     * Set seat
     *
     * @param integer $seat
     *
     * @return Classroom
     */
    public function setSeat($seat)
    {
        $this->seat = $seat;

        return $this;
    }

    /**
     * Get seat
     *
     * @return int
     */
    public function getSeat()
    {
        return $this->seat;
    }
}
