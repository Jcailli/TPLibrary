<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture implements DependentFixtureInterface
{
    public const BOOK_REFERENCE = 'book';

    public function load(ObjectManager $manager): void
    {
        $books = [
            [
                'name'=> '1984',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-George-Orwell',
                ]
            ],
            [
                'name'=> 'Le Seigneur des Anneaux',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-J.R.R.-Tolkien',
                ]
            ],
            [
                'name'=> "Harry Potter à l'école des sorciers",
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-J.K.-Rowling',
                    AuthorFixtures::AUTHOR_REFERENCE.'-J.R.R.-Tolkien',
                ]
            ],
            [
                'name'=> 'Les Misérables',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Victor-Hugo',
                ]
            ],
            [
                'name'=> 'La Peste',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Albert-Camus',
                ]
            ],
            [
                'name'=> "L'Étranger",
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Albert-Camus',
                ]
            ],
            [
                'name'=> 'Fahrenheit 451',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Ray-Bradbury',
                ]
            ],
            [
                'name'=> 'Le Petit Prince',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Antoine-de Saint-Exupéry',
                ]
            ],
            [
                'name'=> 'Crime et Châtiment',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Fiodor-Dostoïevski',
                ]
            ],
            [
                'name'=> 'Moby Dick',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Herman-Melville',
                ]
            ],
            [
                'name'=> 'Le Comte de Monte-Cristo',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Alexandre-Dumas',
                    AuthorFixtures::AUTHOR_REFERENCE.'-Marcel-Proust',
                ]
            ],
            [
                'name'=> 'Germinal',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Emile-Zola',
                ]
            ],
            [
                'name'=> 'Madame Bovary',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Gustave-Flaubert',
                ]
            ],
            [
                'name'=> 'La Métamorphose',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Franz-Kafka',
                ]
            ],
        ];

        foreach ($books as $book) {
            $bookEntity = new Book();
            $bookEntity->setName($book['name']);
            foreach ($book['authors'] as $author) {
                $bookEntity->addAuthor($this->getReference($author));
            }
            $manager->persist($bookEntity);
            $this->addReference(self::BOOK_REFERENCE.'-'.$book['name'], $bookEntity);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AuthorFixtures::class,
        ];
    }
}
