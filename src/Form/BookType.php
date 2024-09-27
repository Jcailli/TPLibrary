<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\BookVersion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('authors', EntityType::class, [
                'class' => Author::class,
                'choice_label' => function (Author $author): string {
                    return $author->getFirstName() . " " . $author->getName();
                },
                'attr' => [
                    'class' => 'select2'
                ],
                'expanded' =>false,
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
