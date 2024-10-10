<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuthorFixtures extends Fixture
{
    public const AUTHOR_REFERENCE = 'author';

    public function load(ObjectManager $manager): void
    {
        $authors = [
            [
                'name' => 'Orwell',
                'firstName' => 'George',
            ],
            [
                'name' => 'Tolkien',
                'firstName' => 'J.R.R.',
            ],
            [
                'name' => 'Rowling',
                'firstName' => 'J.K.',
            ],
            [
                'name' => 'Hugo',
                'firstName' => 'Victor',
            ],
            [
                'name' => 'Camus',
                'firstName' => 'Albert',
            ],
            [
                'name' => 'Bradbury',
                'firstName' => 'Ray',
            ],
            [
                'name' => 'de Saint-Exupéry',
                'firstName' => 'Antoine',
            ],
            [
                'name' => 'Dostoïevski',
                'firstName' => 'Fiodor',
            ],
            [
                'name' => 'Melville',
                'firstName' => 'Herman',
            ],
            [
                'name' => 'Proust',
                'firstName' => 'Marcel',
            ],
            [
                'name' => 'Dumas',
                'firstName' => 'Alexandre',
            ],
            [
                'name' => 'Zola',
                'firstName' => 'Emile',
            ],
            [
                'name' => 'Flaubert',
                'firstName' => 'Gustave',
            ],
            [
                'name' => 'Kafka',
                'firstName' => 'Franz',
            ],
            [
                'name'      => 'Süskind',
                'firstName' => 'Patrick',
            ],
            [
                'name'      => 'Baudelaire',
                'firstName' => 'Charles',
            ],
            [
                'name'      => 'Homère',
                'firstName' => '',
            ],
            [
                'name'      => 'Austen',
                'firstName' => 'Jane',
            ],
            [
                'name'      => 'Shelley',
                'firstName' => 'Mary',
            ],
            [
                'name'      => 'Stendhal',
                'firstName' => '',
            ],
            [
                'name'      => 'Huxley',
                'firstName' => 'Aldous',
            ],
            [
                'name'      => 'de Cervantes',
                'firstName' => 'Miguel',
            ],
            [
                'name'      => 'Coelho',
                'firstName' => 'Paulo',
            ],
            [
                'name'      => 'Herbert',
                'firstName' => 'Frank',
            ],
            [
                'name'      => 'King',
                'firstName' => 'Stephen',
            ],
            [
                'name'      => 'Gaiman',
                'firstName' => 'Neil',
            ],
            [
                'name'      => 'McCarthy',
                'firstName' => 'Cormac',
            ],
            [
                'name'      => 'Morrison',
                'firstName' => 'Toni',
            ],
            [
                'name'      => 'Hemingway',
                'firstName' => 'Ernest',
            ],
            [
                'name'      => 'Salinger',
                'firstName' => 'J.D.',
            ],
            [
                'name'      => 'Eco',
                'firstName' => 'Umberto',
            ],
            [
                'name'      => 'Noah Harari',
                'firstName' => 'Yuval',
            ],
            [
                'name'      => 'Gaarder',
                'firstName' => 'Jostein',
            ],
            [
                'name'      => 'Kundera',
                'firstName' => 'Milan',
            ],
            [
                'name'      => 'Joyce',
                'firstName' => 'James',
            ],
            [
                'name'      => 'Zweig',
                'firstName' => 'Stefan',
            ],
            [
                'name'      => 'García Márquez',
                'firstName' => 'Gabriel',
            ],
            [
                'name'      => 'Brontë',
                'firstName' => 'Charlotte',
            ],
            [
                'name'      => 'Mann',
                'firstName' => 'Thomas',
            ],
            [
                'name'      => 'Kerouac',
                'firstName' => 'Jack',
            ],
            [
                'name'      => 'Conan Doyle',
                'firstName' => 'Arthur',
            ],
            [
                'name'      => 'Verne',
                'firstName' => 'Jules',
            ],
            [
                'name'      => 'Machiavel',
                'firstName' => 'Nicolas',
            ],
            [
                'name'      => 'Mull',
                'firstName' => 'Brandon',
            ],
        ];

        foreach ($authors as $author) {
            $authorEntity = new Author();
            $authorEntity->setName($author['name']);
            $authorEntity->setFirstName($author['firstName']);
            $manager->persist($authorEntity);
            $this->addReference(self::AUTHOR_REFERENCE.'-'.$author['firstName'].'-'.$author['name'], $authorEntity);
        }

        $manager->flush();
    }
}
