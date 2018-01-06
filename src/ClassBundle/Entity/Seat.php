<?php

namespace ClassBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Seat
 *
 * @ORM\Table(name="seat", uniqueConstraints={@ORM\UniqueConstraint(columns={"number", "seat_class_id", "student_id"})})
 * @ORM\Entity(repositoryClass="ClassBundle\Repository\SeatRepository")
 * @UniqueEntity(fields={"number", "seatClass"}, message="This number is already used in this classroom.")
 * @UniqueEntity(fields={"seatStudent"}, message="This student is already exist in a another classroom.")
 */
class Seat
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
     * @var int
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @ORM\OneToOne(targetEntity="Student")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id", nullable=true)
     */
    private $seatStudent;

    /**
     * @ORM\ManyToOne(targetEntity="Classroom", inversedBy="seat")
     * @ORM\JoinColumn(name="seat_class_id", referencedColumnName="id")
     */
    private $seatClass;

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
     * Set number
     *
     * @param integer $number
     *
     * @return Seat
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**

     * Set seatStudent
     *
     * @param int $seatStudent
     *
     * @return Seat
     */

    public function setSeatStudent($seatStudent)
    {
        $this->seatStudent = $seatStudent;
        return $this;
    }

    /**

     * Get seatStudent
     *
     * @return Seat
     */

    public function getSeatStudent()
    {
        return $this->seatStudent;
    }

    public function addSeatStudent($seatStudent)
    {
      $this->seatStudent[] += $seatStudent;
    }

    /**
     * Set seatClass
     *
     * @param integer $seatClass
     *
     * @return Seat
     */
    public function setSeatClass($seatClass){
        $this->seatClass = $seatClass;

        return $this;
    }

    /**
     * Get seatClass
     *
     * @return Seat
     */
    public function getSeatClass()
    {
        return $this->seatClass;
    }
}
