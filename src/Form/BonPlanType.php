<?php

namespace App\Form;

use App\Entity\BonPlan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BonPlanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            /* ->add('dateExpiration') */
            ->add('description')
            ->add('prixHabituel')
            ->add('prixReduction')
            ->add('lien')
            ->add('fraisLivraison')
            ->add('categories')
            ->add('codePromo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BonPlan::class,
        ]);
    }
}
