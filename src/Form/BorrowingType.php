<?php

namespace App\Form;

use App\Entity\BookVersion;
use App\Entity\Borrowing;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BorrowingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('borrowingDate', null, [
                'widget' => 'single_text',
            ])
            ->add('returnDate', null, [
                'widget' => 'single_text',
            ])
            ->add('returned')
            ->add('bookVersion', EntityType::class, [
                'class' => BookVersion::class,
                'choice_label' => 'id',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Borrowing::class,
        ]);
    }
}
