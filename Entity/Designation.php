<?php


namespace Kamran\ContactsBundle\Entity;



use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table("designation")
 * @ORM\Entity
 */
class Designation
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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=35)
     */
    private $title;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId(){
        return $this->id;
    }

    public function setName($name){
        $this->name = $name;
        return $this;
    }

    public function getName(){
        return $this->name;
    }

    public function setTitle($title){
        $this->title = $title;
        return $this;
    }

    public function getTitle(){
        return $this->title;
    }

    public function __toString(){
        return $this->name;
    }



}//@