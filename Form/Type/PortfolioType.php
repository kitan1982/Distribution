<?php

namespace Icap\PortfolioBundle\Form\Type;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @DI\FormType
 */
class PortfolioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('disposition', 'integer')
            ->add('comments', 'collection', array(
                    'type'   => 'icap_portfolio_portfolio_comment_form',
                    'by_reference'  => false,
                    'allow_add'     => true,
                    'allow_delete'  => true
                )
            )
            ->add('commentsViewAt', 'datetime', array(
                    'widget' => 'single_text'
                ))
            ->add('widgets', 'text', array('mapped' => false));
    }

    public function getName()
    {
        return 'icap_portfolio_portfolio_form';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class'         => 'Icap\PortfolioBundle\Entity\Portfolio',
                'translation_domain' => 'icap_portfolio',
                'csrf_protection'    => false,
                'date_format'        => DateTimeType::HTML5_FORMAT
            )
        );
    }
}
