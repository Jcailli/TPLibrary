<?php

namespace App\Form;

use App\Entity\Borrowing;
use App\Entity\Reservation;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    "Administrateur" => "ROLE_ADMIN",
                    "Utilisateur" => "ROLE_USER",
                    "Bibliothécaire" => "ROLE_LIBRARIAN"
                ],
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('username', TextType::class, [
                'required' => true,
            ])
            ->add('userFirstName', TextType::class, [
                'label' => "First Name",
            ])
            ->add('email')
            ->add('penality')
            ->add('borrowing', EntityType::class, [
                'class' => Borrowing::class,
                'choice_label' => 'id',
            ])
            ->add('reservation', EntityType::class, [
                'class' => Reservation::class,
                'choice_label' => 'id',
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
