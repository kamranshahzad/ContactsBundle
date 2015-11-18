<?php

namespace Kamran\ContactsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class DesignationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name','text',array(
            'label'=>false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder'=>'Name'
            ),
        ));
        $builder->add('title','text',array(
            'label'=>false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder'=>'Title'
            ),
        ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kamran\ContactsBundle\Entity\Designation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'designation_form';
    }
}
