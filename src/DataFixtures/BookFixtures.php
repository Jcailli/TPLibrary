<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $books = [
            [
                'name'=> '1984',
            ],
            [
                'name'=> 'Le Seigneur des Anneaux',
            ],
            [
                'name'=> "Harry Potter à l'école des sorciers",
            ],
            [
                'name'=> 'Les Misérables',
            ],
            [
                'name'=> 'La Peste',
            ],
            [
                'name'=> "L'Étranger",
            ],
            [
                'name'=> 'Fahrenheit 451',
            ],
            [
                'name'=> 'Le Petit Prince',
            ],
            [
                'name'=> 'Crime et Châtiment',
            ],
            [
                'name'=> 'Moby Dick',
            ],
            [
                'name'=> 'Le Comte de Monte-Cristo',
            ],
            [
                'name'=> 'Germinal',
            ],
            [
                'name'=> 'Madame Bovary',
            ],
            [
                'name'=> 'La Métamorphose',
            ],
        ];

        foreach ($books as $book) {
            $bookEntity = new Book();
            $bookEntity->setName($book['name']);
            $manager->persist($bookEntity);
        }

        $manager->flush();
    }
}
