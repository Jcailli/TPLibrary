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
