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
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Le Parfum',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Fayard',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Les Fleurs du mal',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Poulet-Malassis',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-L\'Odyssée',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Les Belles Lettres',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Orgueil et Préjugés',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-T. Egerton',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Frankenstein',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Lackington',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Le Rouge et le Noir',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Levavasseur',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Le Meilleur des mondes',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Chatto & Windus',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Don Quichotte',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Francisco de Robles',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-L\'Alchimiste',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-HarperCollins',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Dune',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Chilton Books',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Shining',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Doubleday',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-American Gods',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-William Morrow',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-La Route',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Knopf',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Beloved',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Alfred A. Knopf',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Le Vieil Homme et la Mer',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Charles Scribner\'s Sons',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-L\'Attrape-cœurs',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Little, Brown and Company',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Le Nom de la Rose',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Bompiani',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Sapiens : Une brève histoire de l\'humanité',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Albin Michel',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Le Monde de Sophie',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Seuil',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Les Frères Karamazov',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Flammarion',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-L\'insoutenable légèreté de l\'être',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Gallimard',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Ulysse',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Sylvia Beach',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Le Joueur d\'échecs',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Le Livre de Poche',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Cent ans de solitude',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Harper & Row',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Jane Eyre',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Smith, Elder & Co.',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-La Chartreuse de Parme',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Michel Lévy Frères',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-La Montagne magique',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-S. Fischer Verlag',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Sur la route',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Viking Press',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-La Chute',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Gallimard',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-La Recherche du temps perdu',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Gallimard',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Les Aventures de Sherlock Holmes',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-George Newnes',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-L\'île mystérieuse',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Hetzel',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Le Hobbit',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Allen & Unwin',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Les Trois Mousquetaires',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Baudry',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Le Prince',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Antonio Blado d\'Asola',
            ],
            [
                'book' => BookFixtures::BOOK_REFERENCE.'-Fablehaven - Le Sanctuaire secret',
                'publisher' => PublisherFixtures::PUBLISHER_REFERENCE.'-Nathan',
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
