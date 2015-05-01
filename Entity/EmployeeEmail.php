<?php

namespace Cogilent\ContactsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Cogilent\ContactsBundle\Entity\Employee;


/**
 * EmployeeEmail
 *
 * @ORM\Table(name="employee_emails")
 * @ORM\Entity
 */
class EmployeeEmail
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
     * @ORM\ManyToOne(targetEntity="Cogilent\ContactsBundle\Entity\Employee", inversedBy="emails")
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     * @var type
     */
    private $employee;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=150  , nullable=true)
     */
    private $email;

    /**
     *
     * @ORM\Column(name="email_type", type="string", columnDefinition="ENUM('u','p', 'o')")
     */
    private $emailType;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
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

    /**
     * Set email
     *
     * @param string $email
     * @return EmployeeEmail
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set emailType
     *
     * @param string $emailType
     * @return EmployeeEmail
     */
    public function setEmailType($emailType)
    {
        $this->emailType = $emailType;

        return $this;
    }

    /**
     * Get emailType
     *
     * @return string 
     */
    public function getEmailType()
    {
        return $this->emailType;
    }
}
