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
            [
                'name'=> 'Le Parfum',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Patrick-Süskind',
                ]
            ],
            [
                'name'=> 'Les Fleurs du mal',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Charles-Baudelaire',
                ]
            ],
            [
                'name'=> 'L\'Odyssée',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'--Homère',
                ]
            ],
            [
                'name'=> 'Orgueil et Préjugés',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Jane-Austen',
                ]
            ],
            [
                'name'=> 'Frankenstein',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Mary-Shelley',
                ]
            ],
            [
                'name'=> 'Le Rouge et le Noir',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'--Stendhal',
                ]
            ],
            [
                'name'=> 'Le Meilleur des mondes',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Aldous-Huxley',
                ]
            ],
            [
                'name'=> 'Don Quichotte',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Miguel-de Cervantes',
                ]
            ],
            [
                'name'=> 'L\'Alchimiste',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Paulo-Coelho',
                ]
            ],
            [
                'name'=> 'Dune',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Frank-Herbert',
                ]
            ],
            [
                'name'=> 'Shining',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Stephen-King',
                ]
            ],
            [
                'name'=> 'American Gods',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Neil-Gaiman',
                ]
            ],
            [
                'name'=> 'La Route',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Cormac-McCarthy',
                    AuthorFixtures::AUTHOR_REFERENCE.'-Marcel-Proust',
                ]
            ],
            [
                'name'=> 'Beloved',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Toni-Morrison',
                ]
            ],
            [
                'name'=> 'Le Vieil Homme et la Mer',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Ernest-Hemingway',
                ]
            ],
            [
                'name'=> 'L\'Attrape-cœurs',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-J.D.-Salinger',
                ]
            ],
            [
                'name'=> 'Le Nom de la Rose',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Umberto-Eco',
                ]
            ],
            [
                'name'=> 'Sapiens : Une brève histoire de l\'humanité',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Yuval-Noah Harari',
                ]
            ],
            [
                'name'=> 'Le Monde de Sophie',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Jostein-Gaarder',
                ]
            ],
            [
                'name'=> 'Les Frères Karamazov',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Fiodor-Dostoïevski',
                ]
            ],
            [
                'name'=> 'L\'insoutenable légèreté de l\'être',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Milan-Kundera',
                ]
            ],
            [
                'name'=> 'Ulysse',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-James-Joyce',
                ]
            ],
            [
                'name'=> 'Le Joueur d\'échecs',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Stefan-Zweig',
                ]
            ],
            [
                'name'=> 'Cent ans de solitude',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Gabriel-García Márquez',
                ]
            ],
            [
                'name'=> 'Jane Eyre',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Charlotte-Brontë',
                ]
            ],
            [
                'name'=> 'La Chartreuse de Parme',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'--Stendhal',
                ]
            ],
            [
                'name'=> 'La Montagne magique',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Thomas-Mann',
                ]
            ],
            [
                'name'=> 'Sur la route',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Jack-Kerouac',
                ]
            ],
            [
                'name'=> 'La Chute',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Albert-Camus',
                    AuthorFixtures::AUTHOR_REFERENCE.'-Marcel-Proust',
                ]
            ],
            [
                'name'=> 'La Recherche du temps perdu',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Marcel-Proust',
                ]
            ],
            [
                'name'=> 'Les Aventures de Sherlock Holmes',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Arthur-Conan Doyle',
                ]
            ],
            [
                'name'=> 'L\'île mystérieuse',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Jules-Verne',
                ]
            ],
            [
                'name'=> 'Le Hobbit',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-J.R.R.-Tolkien',
                ]
            ],
            [
                'name'=> 'Les Trois Mousquetaires',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Alexandre-Dumas',
                ]
            ],
            [
                'name'=> 'Le Prince',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Nicolas-Machiavel',
                ]
            ],
            [
                'name'=> 'Fablehaven - Le Sanctuaire secret',
                'authors'=>[
                    AuthorFixtures::AUTHOR_REFERENCE.'-Brandon-Mull',
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
