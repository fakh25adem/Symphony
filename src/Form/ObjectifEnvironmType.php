<?php

namespace App\Form;

use App\Entity\ActionEnvironm;
use App\Entity\ObjectifEnvironm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObjectifEnvironmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('date_debut', null, [
                'widget' => 'single_text',
            ])
            ->add('date_fin', null, [
                'widget' => 'single_text',
            ])
            ->add('statut')
            ->add('pts_cible')
            ->add('pts_cummules')
            ->add('actions', EntityType::class, [
                'class' => ActionEnvironm::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ObjectifEnvironm::class,
            'csrf_protection' => false,
        ]);
    }
}
