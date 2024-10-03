<?php

namespace App\DataFixtures;

use App\Entity\BookVersion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookVersionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $bookVersions = [
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-1984',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Secker & Warburg',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Le Seigneur des Anneaux',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Allen & Unwin',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Harry Potter à l\'école des sorciers',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Bloomsbury',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Les Misérables',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Gallimard',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-La Peste',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Gallimard',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-L\'Étranger',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Gallimard',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Fahrenheit 451',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Ballantine Books',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Le Petit Prince',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Gallimard',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Crime et Châtiment',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Flammarion',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Moby Dick',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Harper & Brothers',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Le Comte de Monte-Cristo',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Pélerin',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Germinal',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Fasquelle',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Madame Bovary',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Charpentier',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-La Métamorphose',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Kurt Wolff Verlag',
            ],
        ];

        foreach ($bookVersions as $bookVersion) {
            $bookVersionEntity = new BookVersion();
            $bookVersionEntity->setName('Première Version');
            $bookVersionEntity->setBook($this->getReference($bookVersion['book']));
            $bookVersionEntity->setPublisher($this->getReference($bookVersion['publisher']));
            $bookVersionEntity->setVersionDate(new \DateTime('01/01/1950'));
            $manager->persist($bookVersionEntity);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            BookFixtures::class,
            PublisherFixtures::class,
        ];
    }
}
