<?php

namespace App\Form;

use App\Entity\BookVersion;
use App\Entity\Borrowing;
use App\Entity\User;
use App\Repository\BookVersionRepository;
use App\Repository\BorrowingRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BorrowingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bookVersion', EntityType::class, [
                'class' => BookVersion::class,
                'label' => 'Livre à emprunter',
                'query_builder' => function (BookVersionRepository $bookVersionRepository): QueryBuilder {
                    return $bookVersionRepository
                        ->createQueryBuilder('bookVersion')
                        ->leftJoin(Borrowing::class, 'borrowing', 'WITH', 'borrowing.bookVersion = bookVersion.id')
                        ->where('borrowing.bookVersion IS NULL');
                },
                'choice_label' => function (BookVersion $bookVersion): string {
                    $bookVersionName = $bookVersion->getName();
                    $bookName = $bookVersion->getBook()->getName();
                    $bookAuthorsList = $bookVersion->getBook()->getAuthors();
                    $bookAuthors = '';
                    foreach($bookAuthorsList as $bookAuthor) {
                        $bookAuthors .= $bookAuthor->getFirstName() . ' ' . $bookAuthor->getName();
                    }
                    return "Version : " . $bookVersionName . ", Nom : " . $bookName . ", Auteur(s) : " . $bookAuthors;
                },
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
