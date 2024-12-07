<?php

namespace App\Form;

use App\Entity\ActionEnvironm;
use App\Entity\CategorieAction;
use App\Entity\ObjectifEnvironm;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActionEnvironmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type')
            ->add('description')
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('impact_carbon')

            ->add('categorie', EntityType::class, [
                'class' => CategorieAction::class,
                'choice_label' => 'id',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('objectifs', EntityType::class, [
                'class' => ObjectifEnvironm::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ActionEnvironm::class,
        ]);
    }
}