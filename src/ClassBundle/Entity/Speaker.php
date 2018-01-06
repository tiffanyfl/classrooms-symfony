<?php

namespace ClassBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Speaker
 *
 * @ORM\Table(name="speaker")
 * @ORM\Entity(repositoryClass="ClassBundle\Repository\SpeakerRepository")
 * @UniqueEntity(fields={"name","firstname","subject"}, message="This speaker is already used with this subject.")
 */
class Speaker
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, unique=true)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255, unique=true)
     */
    private $subject;

    /**
     * @ORM\OneToOne(targetEntity="Classroom", mappedBy="speaker")
     */
    private $classroom;
    
    public function __toString(){
        return $this->name.' '.$this->firstname.' '.$this->subject;
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
     * @return Speaker
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
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Speaker
     */
    public function setFirstName($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstname;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return Speaker
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set classroom
     *
     * @param string $classroom
     *
     * @return Speaker
     */
    public function setClassroom($classroom)
    {
        $this->classroom = $classroom;

        return $this;
    }

    /**
     * Get classroom
     *
     * @return string
     */
    public function getClassroom()
    {
        return $this->classroom;
    }
}

