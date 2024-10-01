<?php

namespace App\Form;

use App\Entity\BookVersion;
use App\Entity\Borrowing;
use App\Entity\Reservation;
use App\Entity\User;
use App\Repository\BookVersionRepository;
use DateInterval;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bookVersion', EntityType::class, [
                'class' => BookVersion::class,
                'choice_label' => function (BookVersion $bookVersion) {
                    return $bookVersion->getBook()->getName() . ' : ' . $bookVersion->getName();
                },
                'query_builder' => function (BookVersionRepository $bookVersionRepository) {
                    return $bookVersionRepository->createQueryBuilder('b')
                        ->innerJoin(
                            Borrowing::class,
                            'borrowing',
                            'WITH',
                            'borrowing.bookVersion = b.id'
                        )
                        ->leftJoin(
                            Reservation::class,
                            'reservation',
                            'WITH',
                            'reservation.bookVersion = b.id'
                        )
                        ->where('reservation.bookVersion IS NULL')
                        ->andWhere('borrowing.returned = :status OR borrowing.returnDate >= :returnedDate')
                        ->setParameter('status', false)
                        ->setParameter(
                            'returnedDate',
                            (new \DateTime('today'))
                                ->add(DateInterval::createFromDateString('2 day'))
                        );
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
