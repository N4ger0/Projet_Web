<?php

namespace App\Form;

use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PanierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $myRange = range($options['quantityMin'], $options['quantityMax']);
        $builder
            ->add('quantity', ChoiceType::class, [
                'choices' => array_combine($myRange, $myRange),
                'label'=> false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'quantityMax' => 0, //valeur par defaut
            'quantityMin' => 0,
        ]);
    }
}
