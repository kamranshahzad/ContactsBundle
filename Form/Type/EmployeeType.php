<?php

namespace Kamran\ContactsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname','text',array(
            'label'=>false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder'=>'First Name'
            ),
        ));

        $builder->add('lastname','text',array(
            'label'=>false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder'=>'Last Name'
            ),
        ));

        $builder->add('gender', 'choice', array(
            'choices' => array('m' => 'Male', 'f' => 'Female'),
            'expanded'=>true
        ));

        $builder->add('address','textarea',array(
            'required'=>false,
            'label'=>false,
            'attr' => array(
                'class' => 'codetext form-control',
                'placeholder'=>'Address'
            ),
        ));

        $builder->add('designation', 'entity', array(
            'class' => 'KamranContactsBundle:Designation',
            'property' => 'name',
            'label' => false,
            'attr' => array(
                'class' => 'form-control'
            ),
        ));

        $builder->add('office', 'entity', array(
            'class' => 'KamranOrganizationBundle:Office',
            'property' => 'name',
            'label' => false,
            'attr' => array(
                'class' => 'form-control'
            ),
        ));

        $builder->add('contacts','collection',array(
            'type'=> new EmployeeContactsType(),
            'label' => false,
            'allow_add' => true,
            'allow_delete' => true,
        ));

        $builder->add('emails','collection',array(
            'type'=> new EmployeeEmailType(),
            'label' => false,
            'allow_add' => true,
            'allow_delete' => true,
        ));

        $builder->add('emergencyName','text',array(
            'label' => false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder'=>'Name'
            ),
        ));

        $builder->add('emergencyRelation','text',array(
            'label'=>false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder'=>'Relation'
            ),
        ));

        $builder->add('emergencyContact','text',array(
            'label'=>false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder'=>'Contact'
            ),
        ));
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Kamran\ContactsBundle\Entity\Employee',
        ));
    }

    public function getName()
    {
        return 'employee_form';
    }
}
