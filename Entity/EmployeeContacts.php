<?php

namespace Cogilent\ContactsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="employee_contacts")
 */
class EmployeeContacts
{
   /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="contacts")
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     * @var type
     */
    private $employee;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=30)
     */
    private $phoneNumber;

    /**
     *
     * @ORM\Column(name="number_type", type="string", columnDefinition="ENUM('u','c', 'l', 'o', 'h')")
     */
    private $numberType;

    /**
     *
     * @ORM\Column(name="country_code", type="string", length=30 , nullable=true)
     */
    private $countryCode;


    /**
     *
     * @ORM\Column(name="office_extension", type="string", length=30 , nullable=true)
     */
    private $officeExtension;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId(){
        return $this->id;
    }


    public function setEmployee(Employee $emp)
    {
        $this->employee = $emp;
    }

    public function getEmployee()
    {
        return $this->employee;
    }

    public function setPhoneNumber($phoneNumber){
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function getPhoneNumber(){
        return $this->phoneNumber;
    }

    public function setNumberType($numberType){
        $this->numberType = $numberType;
        return $this;
    }

    public function getNumberType(){
        return $this->numberType;
    }

    public function setCountryCode($countryCode){
        $this->countryCode = $countryCode;
        return $this;
    }

    public function getCountryCode(){
        return $this->countryCode;
    }

    public function setOfficeExtension($officeExtension){
        $this->officeExtension = $officeExtension;
        return $this;
    }

    public function getOfficeExtension(){
        return $this->officeExtension;
    }

}//@
