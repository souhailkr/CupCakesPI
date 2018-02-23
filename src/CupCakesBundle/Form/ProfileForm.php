<?php

namespace CupCakesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('image', FileType::class, array('data_class' => null));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType' ;

    }

    public function getBlockPrefix()
    {
        return 'cup_cakes_bundle_profile_form';
    }
}
