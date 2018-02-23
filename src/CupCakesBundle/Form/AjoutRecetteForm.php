<?php

namespace CupCakesBundle\Form;

use CupCakesBundle\Entity\Etape;
use CupCakesBundle\Entity\Ingredient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AjoutRecetteForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')->add('temps_preparation')->
        add('temps_cuisson')->add('difficulte', ChoiceType::class, array(
            'choices' => array(
                'Facile' => 'Facile',
                'Moyen' => 'Moyen',
                'Difficile'   => 'Difficile',
            )))->add('categorie', ChoiceType::class, array(
        'choices' => array(
            'sucré' => 'sucré',
            'salée' => 'Salée',
        )))
            ->add('description')->add('nb_personnes')->

            add('image', FileType::class, array('data_class' => null));


        $builder->add('ingredients', CollectionType::class, array(
            'entry_type' => IngredientForm::class,
            'entry_options' => array('label' => false),
            'allow_add' => true,
            'by_reference' => false,
            'allow_delete' => true,


        ));


        $builder->add('etapes', CollectionType::class, array(
            'entry_type' => Tag::class,
            'entry_options' => array('label' => false),
            'allow_add' => true,
            'by_reference' => false,
            'allow_delete' => true,
            'required' => true


        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CupCakesBundle\Entity\Recette',
            'csrf_protection' => false

        ));
    }

    public function getBlockPrefix()
    {
        return 'cup_cakes_bundle_ajout_recette_form';
    }
}
