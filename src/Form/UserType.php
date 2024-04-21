<?php

namespace App\Form;

use App\Entity\Pays;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('login')
            ->add('password')
            ->add('name', TextType::class, [
                'required' => true ,
            ])
            ->add('lastname', TextType::class, [
                'required' => true ,
            ])
            ->add('birthdate', DateType::class, [
                'required' => true,
                'html5' => false,
                'format' => 'yyyy-MM-dd',
                'years' => range(date('Y'), 1900),
            ])
            ->add('pays', EntityType::class, [
                'required' => false,
                'class' => Pays::class,
                'choice_label' => 'name',
                'placeholder' => '------',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
