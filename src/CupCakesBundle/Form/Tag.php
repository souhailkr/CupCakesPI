<?php

namespace CupCakesBundle\Form;

use CupCakesBundle\Entity\Etape;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Tag extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('description');

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Etape::class,
            'csrf_protection' => false

        ));
    }

    public function getBlockPrefix()
    {
        return 'cup_cakes_bundle_tag';
    }
}
