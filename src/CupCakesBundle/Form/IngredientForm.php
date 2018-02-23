<?php

namespace CupCakesBundle\Form;
use CupCakesBundle\Entity\Ingredient;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IngredientForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')->add('quantite');

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Ingredient::class,
            'csrf_protection' => false

        ));
    }

    public function getBlockPrefix()
    {
        return 'cup_cakes_bundle_ingredient_form';
    }
}
