<?php

namespace Cogilent\ContactsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

use Cogilent\OrganizationBundle\Entity\Office;
use Cogilent\OrganizationBundle\Entity\Organization;

/**
 * @ORM\Entity
 * @ORM\Table(name="employee")
 * @ORM\Entity(repositoryClass="Cogilent\ContactsBundle\Entity\Repository\EmployeeRepository")
 */
class Employee
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
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=100)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=100)
     */
    private $lastname;

    /**
     * @ORM\Column(name="gender",type="string", columnDefinition="ENUM('m', 'f')")
     */
    private $gender;

    /**
     * @ManyToOne(targetEntity="Designation")
     * @JoinColumn(name="designation_id", referencedColumnName="id")
     **/
    private $designation;

    /**
     * @ManyToOne(targetEntity="Cogilent\OrganizationBundle\Entity\Office")
     * @JoinColumn(name="office_id", referencedColumnName="id")
     **/
    private $office;

    /**
     * @ORM\ManyToOne(targetEntity="Cogilent\OrganizationBundle\Entity\Organization", inversedBy="employees")
     * @ORM\JoinColumn(name="organization_id", referencedColumnName="id")
     * @var type
     */
    private $organization;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=true)
     */
    private $createdDate;

    /**
     * @ORM\OneToMany(targetEntity="EmployeeContacts", mappedBy="employee", cascade={"persist"})
     * @var type
     */
    private $contacts;

    /**
     * @ORM\OneToMany(targetEntity="EmployeeEmail", mappedBy="employee", cascade={"persist"})
     * @var type
     */
    private $emails;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=100)
     */
    private $address;


    /**
     * @var string
     *
     * @ORM\Column(name="emergency_name", type="string", length=100)
     */
    private $emergencyName;

    /**
     * @var string
     *
     * @ORM\Column(name="emergency_relation", type="string", length=100)
     */
    private $emergencyRelation;

    /**
     * @var string
     *
     * @ORM\Column(name="emergency_contact", type="string", length=30)
     */
    private $emergencyContact;


    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->createdDate = new \DateTime('now');
    }

    public function getId()
    {
        return $this->id;
    }

    public function setFirstname($firstname){
        $this->firstname = $firstname;
        return $this;
    }

    public function getFirstname(){
        return $this->firstname;
    }

    public function setLastname($lastname){
        $this->lastname = $lastname;
        return $this;
    }

    public function getLastname(){
        return $this->lastname;
    }

    public function setGender($gender){
        $this->gender = $gender;
        return $this;
    }

    public function getGender(){
        return $this->gender;
    }

    public function setCreatedDate($createddate){
        $this->createdDate = $createddate;
        return $this;
    }

    public function getCreatedDate(){
        return $this->createdDate;
    }

    public function setDesignation(Designation $designation){
        $this->designation = $designation;
        return $this;
    }

    public function getDesignation(){
        return $this->designation;
    }

    public function setOffice(Office $office){
        $this->office = $office;
        return $this;
    }

    public function getOffice(){
        return $this->office;
    }


    public function getContacts(){
        return $this->contacts;
    }

    public function addContacts(EmployeeContacts $contacts){
        $this->contacts[] = $contacts;
        $contacts->setEmployee($this);
    }

    public function setContacts(EmployeeContacts $contacts){
        $this->contacts = $contacts;
        foreach ($contacts as $contact){
            $contact->setEmployee($this);
        }
    }

    public function addContact(EmployeeContacts $contacts){
        $this->contacts[] = $contacts;
        return $this;
    }

    public function removeContact(EmployeeContacts $contacts)
    {
        $this->contacts->removeElement($contacts);
    }


    public function getEmails(){
        return $this->emails;
    }

    public function addEmails(EmployeeEmail $emails){
        $this->emails[] = $emails;
        $emails->setEmployee($this);
    }

    public function setEmails(EmployeeEmail $emails){
        $this->emails = $emails;
        foreach ($emails as $email){
            $email->setEmployee($this);
        }
    }

    public function addEmail(EmployeeEmail $emails){
        $this->emails[] = $emails;
        return $this;
    }

    public function removeEmail(EmployeeEmail $emails){
        $this->emails->removeElement($emails);
    }

    public function setAddress($address){
        $this->address = $address;
        return $this;
    }

    public function getAddress(){
        return $this->address;
    }

    public function setOrganization(Organization $organization){
        $this->organization = $organization;
    }

    public function getOrganization(){
        return $this->organization;
    }

    public function setEmergencyName($emergencyName){
        $this->emergencyName = $emergencyName;
        return $this;
    }

    public function getEmergencyName(){
        return $this->emergencyName;
    }

    public function setEmergencyRelation($emergencyRelation){
        $this->emergencyRelation = $emergencyRelation;
        return $this;
    }

    public function getEmergencyRelation(){
        return $this->emergencyRelation;
    }

    public function setEmergencyContact($emergencyContact){
        $this->emergencyContact = $emergencyContact;
        return $this;
    }

    public function getEmergencyContact(){
        return $this->emergencyContact;
    }

}//@
