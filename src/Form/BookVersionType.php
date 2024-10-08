<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\BookVersion;
use App\Entity\Borrowing;
use App\Entity\Publisher;
use App\Entity\Reservation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookVersionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('book', EntityType::class, [
                'class' => Book::class,
                'choice_label' => 'name',
            ])
            ->add('publisher', EntityType::class, [
                'class' => Publisher::class,
                'choice_label' => 'name',
            ])
            ->add('versionDate', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BookVersion::class,
        ]);
    }
}
