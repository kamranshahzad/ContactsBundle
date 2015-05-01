<?php

namespace Cogilent\ContactsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

use Cogilent\ContactsBundle\Entity\Employee;
use Cogilent\ContactsBundle\Entity\EmployeeContacts;
use Cogilent\ContactsBundle\Entity\Designation;
use Cogilent\ContactsBundle\Form\Type\EmployeeType;
use Cogilent\ContactsBundle\Form\Type\EmployeeContactsType;
use Cogilent\ContactsBundle\Form\Type\BulkUploadType;
use Cogilent\ContactsBundle\Form\Type\DesignationType;



/**
 * Contacts  ContactsController
 * @Route("/contacts")
 */
class ContactsController extends Controller
{

    /**
     * @Route("/", name="contacts_index")
     * @Template()
     */
    public function indexAction(Request $request){

        return array();
    }

    /**
     * @Route("/Details/{id}", name="contacts_details")
     * @Template()
     */
    public function detailsAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository("CogilentContactsBundle:Employee")->findAll();
        $outputArray = array();


        foreach($entity as $obj){
            if($obj->getId() == $id){

                $array = array();
                $emailcount = 0;
                $contactcount = 0;
                $emailsubarray = array();
                $contactsubarray = array();
                //$office = $em->getRepository("CogilentOrganizationBundle:Office")->find($obj->getId());
                $email = $em->getRepository("CogilentContactsBundle:EmployeeEmail")->findAll();
                $contact = $em->getRepository("CogilentContactsBundle:EmployeeContacts")->findAll();
                $array['id']    = $obj->getId();
                $array['firstname']  = $obj->getFirstname();
                $array['lastname']  = $obj->getLastname();
                $array['gender']  = ('m' == $obj->getGender()) ? 'Male' : 'Female';
                $array['office']  = $obj->getOffice()->getName();//office->getName();
                $array['designation'] = $obj->getDesignation()->getTitle();
                foreach ($email as $emails) {
                    if($emails->getEmployee()->getId() == $obj->getId()){
                        $emailsubarray['emailtype'] = ('o' == $emails->getEmailType())? 'Official':'Personal';
                        $emailsubarray['email'] = $emails->getEmail();
                        $array['email'][$emailcount] = $emailsubarray;
                        $emailcount = $emailcount + 1 ;
                    }
                }
                $conatactsShortArray = array('c' => 'Cell', 'l' => 'Landline', 'o' => 'Office', 'h' => 'Home');
                foreach ($contact as $contacts) {
                    if($contacts->getEmployee()->getId() == $obj->getId()){
                        $contactsubarray['contacttype'] = $contacts->getNumberType();
                        $contactsubarray['contact'] = $contacts->getPhoneNumber();

                        $array['contact'][$contactcount] = $contactsubarray;
                        $contactcount = $contactcount + 1 ;
                    }
                }
                // $array['contact'] = $contactsubarray;

                $outputArray[]  = $array;
            }
        }

        return array(
            'details' => $outputArray,
        );
    }

    /**
     * @Route("/add", name="contacts_add")
     * @Template()
     */
    public function addAction(Request $request){

        $entity = new Employee();
        $form = $this->createForm(new EmployeeType(), $entity);


        if ($request->getMethod() === 'POST'){
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                foreach($entity->getContacts() as $contact) {
                    $contact->setEmployee($entity);
                    $em->persist($contact);
                }
                foreach($entity->getEmails() as $email) {
                    $email->setEmployee($entity);
                    $em->persist($email);
                }
                $em->flush();
                return $this->redirect($this->generateUrl('contacts_index'));
                //return $this->redirect($this->generateUrl('snippets_edit',array('id'=>$entity->getId())));
            }else{
                foreach ($form->getErrors() as $key => $error) {
                    $errors[] = $error->getMessage();
                }
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/edit/{id}", name="contacts_edit")
     * @Template()
     */
    public function editAction($id, Request $request) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CogilentContactsBundle:Employee')->findOneBy(array('id' => $id));

        $form = $this->createForm(new EmployeeType(), $entity);
        //$request = $this->getRequest();

        if ($request->getMethod() === 'POST'){
            $em = $this->getDoctrine()->getManager();
            $form->bind($request);
            if ($form->isValid()) {
                foreach($entity->getContacts() as $contact) {
                    $contact->setEmployee($entity);
                }
                foreach($entity->getEmails() as $email) {
                    $email->setEmployee($entity);
                }
                $em->flush();
                return $this->redirect($this->generateUrl('contacts_index'));
            }else{
                foreach ($form->getErrors() as $key => $error) {
                    $errors[] = $error->getMessage();
                }
            }
        }
        
        return array(
            'form' => $form->createView(),
            'id' => $id
        );

    }


    /**
     * @Route("/remove/{id}",
     *         name="contact_remove",
     *         requirements={"id" = "\d+"})
     */
    public function removeContactAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository("CogilentContactsBundle:Employee")->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Employee with id=' . $id . ' not found');
        }
        $email = $em->getRepository("CogilentContactsBundle:EmployeeEmail")->findAll();
        $contact = $em->getRepository("CogilentContactsBundle:EmployeeContacts")->findAll();

        foreach ($email as $emails) {
            if($emails->getEmployee()->getId() == $id){

                $entityemail = $em->getRepository("CogilentContactsBundle:EmployeeEmail")->find($emails->getId());
                $em->remove($entityemail);
            }
        }
        foreach ($contact as $contacts) {
            if($contacts->getEmployee()->getId() == $id){
                $entitycontact = $em->getRepository("CogilentContactsBundle:EmployeeContacts")->find($contacts->getId());
                $em->remove($entitycontact);
            }
        }
        $em->remove($entity);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice', 'Selected Employee removed successfully.');
        return $this->redirect($this->generateUrl('contacts_index'));
    }



    /**
     * @Route("/bulk", name="contacts_bulk")
     * @Template()
     */
    public function bulkAction(Request $request){
        $form = $this->createForm(new \Cogilent\UserBundle\Form\BulkUploadType());
        $form->handleRequest($request);
        $message = '';


        if ($form->isValid()) {
            $file = $form->get('input_file')->getData();
            $fileName = $file->getClientOriginalName();
            $fileExtention = $file->guessClientExtension();

            if('xlsx' == $fileExtention ){

                $dir = __DIR__.'/../../../../web/uploads';
                $file->move($dir, $fileName) ;

                return $this->redirect($this->generateUrl('contacts_bulk_view',array('file'=>$fileName)));
            }//@
        }else{
            $errors = $form->getErrors();
            foreach($errors as $error) {
                $message .= '- ' . $error->getMessageTemplate();
            }
        }

        return array(
            'form' => $form->createView(),
            'error' => $message
        );
    }


    /**
     * @Route("/bulk-view/{file}", name="contacts_bulk_view")
     * @Template()
     */
    public function bulkViewAction( Request $request, $file ){

        return array(
            'file' => $file
        );

    }


    /**
     * @Route("/bulk-save", name="contacts_bulk_save")
     * @Template()
     */
    public function bulkSaveAction(Request $request){

    }




    /**
     * @Route("/designations", name="contacts_designation_index")
     * @Template()
     */
    public function designationIndexAction(Request $request){

    }






    /**
     * @Route("/adddesignation", name="contacts_designation_add")
     * @Template()
     */
    public function addDesignationAction(Request $request){
        $entity = new Designation();
        $form = $this->createForm(new DesignationType(), $entity);

        if ($request->getMethod() === 'POST'){
            $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('contacts_designation_index'));
        }

        return array(
            'form' => $form->createView(),
        );
    }


    /**
     * @Route("/editdesignation/{id}", name="contacts_designation_edit")
     * @Template()
     */
    public function editDesignationAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CogilentContactsBundle:Designation')->findOneBy(array('id' => $id));
        $form = $this->createForm(new DesignationType(), $entity);

        if ($request->getMethod() === 'POST'){
            $form->bind($request);
            $em->flush();
            return $this->redirect($this->generateUrl('contacts_designation_index'));
        }

        return array(
            'form' => $form->createView(),
            'id' => $id,
        );
    }


    /**
     * @Route("/removedesignation/{id}", name="contacts_designation_remove")
     * @Template()
     */
    public function removeDesignationAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository("CogilentContactsBundle:Designation")->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Designation with id=' . $id . ' not found');
        }

        $em->remove($entity);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice', 'Selected Designation removed successfully.');
        return $this->redirect($this->generateUrl('contacts_designation_index'));
    }



}//@
