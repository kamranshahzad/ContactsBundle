<?php

namespace Cogilent\ContactsBundle\Controller\Rest;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;

use Kamran\UtilBundle\Base\Util;


/**
 * @Route("/api/contacts")
 */
class ApiController extends FOSRestController
{

    /**
     * @Route(
     *      "/all",
     *      name = "api.contacts.all",
     *      defaults = {
     *          "_format" = "json"
     *      },
     *      requirements = {
     *          "_method" = "GET"
     *      },
     *      options = {
     *          "expose" = true
     *      },
     * )
     * @Rest\View
     */
    public function getContactsAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository("CogilentContactsBundle:Employee")->findAll();
        $outputArray = array();


        foreach($entity as $obj){
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
            $array['address']  = $obj->getAddress();
            //$array['office']  = $obj->getOffice()->getName();//office->getName();
            $array['office'] = '--';
            //$array['designation'] = $obj->getDesignation()->getTitle();
            $array['designation'] = '--';
            foreach ($email as $emails) {
                if($emails->getEmployee()->getId() == $obj->getId()){
                    $emailsubarray['emailtype'] = $emails->getEmailType();
                    $emailsubarray['email'] = $emails->getEmail();
                    $array['email'][$emailcount] = $emailsubarray;
                    $emailcount = $emailcount + 1 ;
                }
            }
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

        return new Response(json_encode($outputArray));

    }

    /**
     * @Route(
     *      "/designations/all",
     *      name = "api.contacts.designations.all",
     *      defaults = {
     *          "_format" = "json"
     *      },
     *      requirements = {
     *          "_method" = "GET"
     *      },
     *      options = {
     *          "expose" = true
     *      },
     * )
     * @Rest\View
     */
    public function getDesignationsAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository("Cogilent\ContactsBundle\Entity\Designation")->findAll();
        $outputArray = array();

        foreach($entity as $obj){
            $array = array();
            $array['id']    = $obj->getId();
            $array['name']  = $obj->getName();
            $array['designation']  = $obj->getTitle();
            $outputArray[]  = $array;
        }

        return new Response(json_encode($outputArray));

    }

    /**
     * @Route(
     *      "/readexcel/{file}",
     *      name = "api.get_sheet.read",
     *      defaults = {
     *          "_format" = "json"
     *      },
     *      requirements = {
     *          "_method" = "GET"
     *      },
     *      options = {
     *          "expose" = true
     *      }
     * )
     * @Rest\View
     */
    public function readExcelAction( Request $request, $file ){

        $base = $this->get('base.helper');
        $fileLocation = $base->webDir1.'/uploads/'.$file;
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject($fileLocation);

        foreach ($phpExcelObject->getWorksheetIterator() as $worksheet) {
            $worksheetTitle     = $worksheet->getTitle();
            $highestRow         = $worksheet->getHighestRow(); // e.g. 10
            $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
            $nrColumns = ord($highestColumn) - 64;

            $dataArray = array();

            for ($col = 0; $col < $highestColumnIndex; ++ $col) {
                $rowArray = array();
                $pointer = 0;
                for ($row = 1; $row <= $highestRow; ++ $row) {
                    $cell = $worksheet->getCellByColumnAndRow($col, $row);
                    $val = $cell->getValue();
                    $rowArray[$pointer] = $val;
                    $pointer++;
                }
                $dataArray[] = $rowArray;
            }
        }

        return new Response(json_encode($dataArray));
    }


    /**
     * @Route(
     *      "/bulk_sheet/save",
     *      name = "contacts.bulk_sheet.save",
     *      defaults = {
     *          "_format" = "json"
     *      },
     *      requirements = {
     *          "_method" = "POST"
     *      },
     *      options = {
     *          "expose" = true
     *      }
     * )
     *
     * @Rest\View
     */
    public function saveBulkSheetAction(Request $request){

        $data = $request->request->all();


        $mappedColumns = array();
        if(array_key_exists('columns',$data)){
            foreach($data['columns'] as $key=>$val){
                if($val != ''){
                    $mappedColumns[$key] = $val;
                }
            }
        }

        $dataArray = array();
        $metaInfo = array('firstname','lastname','gender','address','contacts','emails');
        $base = $this->get('base.helper');
        $fileLocation = $base->webDir1.'/uploads/'.$data['sheetfile'];
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject($fileLocation);

        foreach ($phpExcelObject->getWorksheetIterator() as $worksheet) {
            $worksheetTitle     = $worksheet->getTitle();
            $highestRow         = $worksheet->getHighestRow(); // e.g. 10
            $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
            $nrColumns = ord($highestColumn) - 64;
            for ($row = 1; $row <= $highestRow; ++ $row) {
                $pointer = 1;
                $rowArray = array();
                for ($col = 0; $col < $highestColumnIndex; ++ $col) {
                    $cell = $worksheet->getCellByColumnAndRow($col, $row);
                    $val = $cell->getValue();
                    $rowArray[$pointer] = $val;
                    $pointer++;
                }
                $dataArray[] = $rowArray;
            }
        }

        //start traversing
        $genderShortArray = array('male'=>'m','female'=>'f');

        $tempArray = array();

        if(count($dataArray) > 0) {
            $em = $this->getDoctrine()->getManager();
            $tableRowId = 1;
            $empRefArray = array();
            foreach ($dataArray as $columnNo => $rowArray) {
                $empObject = new \Cogilent\ContactsBundle\Entity\Employee();
                foreach($mappedColumns as $mapColumnNo => $columnName){
                    if($columnName == 'gender'){
                        $empObject->setGender($genderShortArray[Util::value($rowArray[$mapColumnNo])]);
                    }
                    if($columnName != 'emails' && $columnName != 'contacts' && $columnName != 'gender'){
                        $setMethod = 'set'.ucfirst($columnName);
                        if(method_exists($empObject,$setMethod)){
                            call_user_func( array( $empObject , $setMethod ) , Util::value($rowArray[$mapColumnNo]) );
                        }
                    }
                }
                $em->persist($empObject);
                $em->flush();
                $empRefArray[$columnNo] = $empObject->getId();
            }

            $contactShortArray = array('cell'=>'c','landline'=>'l','office'=>'o','home'=>'h');
            $emailShortArray = array('personal'=>'p','official'=>'o');

            foreach ($dataArray as $columnNo => $rowArray) {
                foreach($mappedColumns as $mapColumnNo => $columnName){

                    $empObject = $em->getRepository("Cogilent\ContactsBundle\Entity\Employee")->find($empRefArray[$columnNo]);
                    if($columnName == 'emails') {
                        $emailsArray = explode(',', $rowArray[$mapColumnNo]);
                        foreach ($emailsArray as $element) {
                            $emails = explode(':', $element);
                            $emailType = Util::value($emails[0]);
                            $emailStr = Util::value($emails[1]);
                            $tempArray[] = $emails;
                            if (array_key_exists($emailType, $emailShortArray)) {
                                $emailObject = new \Cogilent\ContactsBundle\Entity\EmployeeEmail();
                                $emailObject->setEmailType($emailShortArray[$emailType]);
                                $emailObject->setEmail($emailStr);
                                $emailObject->setEmployee($empObject);
                                $em->persist($emailObject);
                                $em->flush();
                            }
                        }
                    }
                    if($columnName == 'contacts'){
                        $contactsArray = explode(',',$rowArray[$mapColumnNo]);
                        foreach($contactsArray  as $element){
                            $contacts = explode(':',$element);
                            $contactType = Util::value($contacts[0]);
                            $contactNo = Util::value($contacts[1]);
                            if(array_key_exists($contactType,$contactShortArray)){
                                $contactObject = new \Cogilent\ContactsBundle\Entity\EmployeeContacts();
                                $contactObject->setNumberType($contactShortArray[$contactType]);
                                $contactObject->setPhoneNumber($contactNo);
                                $contactObject->setEmployee($empObject);
                                $em->persist($contactObject);
                                $em->flush();
                            }
                        }
                    }
                }
            }
        } //@if excel sheet have data

        return new Response(json_encode(array('status'=>'done')));
    }


}//@

