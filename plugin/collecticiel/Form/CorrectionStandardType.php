<?php

namespace Innova\CollecticielBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CorrectionStandardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('totalGrade', 'number', array('required' => true));
    }

    public function getName()
    {
        return 'innova_collecticiel_correct_standard_form';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'innova_collecticiel'
        ));
    }
}