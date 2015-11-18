<?php

namespace Kamran\ContactsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('KamranContactsBundle:Default:index.html.twig', array('name' => $name));
    }
}
