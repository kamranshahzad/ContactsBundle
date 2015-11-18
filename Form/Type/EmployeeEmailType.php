<?php

namespace Kamran\ContactsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmployeeEmailType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $emailTypes = array('u'=>'Unspecified' , 'p' => 'Personal', 'o' => 'Official' );

        $defaultOptions = array(
            'multiple'=>false,
            'expanded'=>true ,
            'data' => 'u',
            'choice_list' => new SimpleChoiceList($emailTypes)
        );

        //$defaultOptions = array('multiple'=>false,'expanded'=>true , 'choices' => $contactTypes);
        $builder->add('emailType','choice', $defaultOptions );


        $builder->add('email','text',array(
            'label'=>false,
            'required'=>false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder'=>'Email'
            ),
        ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kamran\ContactsBundle\Entity\EmployeeEmail'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'email_form';
    }
}
