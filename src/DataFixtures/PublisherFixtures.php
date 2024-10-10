<?php

namespace App\DataFixtures;

use App\Entity\Publisher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PublisherFixtures extends Fixture
{
    public const PUBLISHER_REFERENCE = 'publisher';

    public function load(ObjectManager $manager): void
    {
        $publishers = [
            [
                'name' => 'Secker & Warburg',
            ],
            [
                'name' => 'Allen & Unwin',
            ],
            [
                'name' => 'Bloomsbury',
            ],
            [
                'name' => 'Gallimard',
            ],
            [
                'name' => 'Ballantine Books',
            ],
            [
                'name' => 'Flammarion',
            ],
            [
                'name' => 'Harper & Brothers',
            ],
            [
                'name' => 'Pélerin',
            ],
            [
                'name' => 'Fasquelle',
            ],
            [
                'name' => 'Charpentier',
            ],
            [
                'name' => 'Kurt Wolff Verlag',
            ],
            [
                'name' => 'Fayard',
            ],
            [
                'name' => 'Poulet-Malassis',
            ],
            [
                'name' => 'Les Belles Lettres',
            ],
            [
                'name' => 'T. Egerton',
            ],
            [
                'name' => 'Lackington',
            ],
            [
                'name' => 'Levavasseur',
            ],
            [
                'name' => 'Chatto & Windus',
            ],
            [
                'name' => 'Francisco de Robles',
            ],
            [
                'name' => 'HarperCollins',
            ],
            [
                'name' => 'Chilton Books',
            ],
            [
                'name' => 'Doubleday',
            ],
            [
                'name' => 'William Morrow',
            ],
            [
                'name' => 'Knopf',
            ],
            [
                'name' => 'Alfred A. Knopf',
            ],
            [
                'name' => 'Charles Scribner\'s Sons',
            ],
            [
                'name' => 'Little, Brown and Company',
            ],
            [
                'name' => 'Bompiani',
            ],
            [
                'name' => 'Albin Michel',
            ],
            [
                'name' => 'Seuil',
            ],
            [
                'name' => 'Sylvia Beach',
            ],
            [
                'name' => 'Le Livre de Poche',
            ],
            [
                'name' => 'Harper & Row',
            ],
            [
                'name' => 'Smith, Elder & Co.',
            ],
            [
                'name' => 'Michel Lévy Frères',
            ],
            [
                'name' => 'S. Fischer Verlag',
            ],
            [
                'name' => 'Viking Press',
            ],
            [
                'name' => 'George Newnes',
            ],
            [
                'name' => 'Hetzel',
            ],
            [
                'name' => 'Baudry',
            ],
            [
                'name' => 'Antonio Blado d\'Asola',
            ],
            [
                'name' => 'Nathan',
            ],
        ];

        foreach ($publishers as $publisher) {
            $publisherEntity = new Publisher();
            $publisherEntity->setName($publisher['name']);
            $manager->persist($publisherEntity);
            $this->addReference(self::PUBLISHER_REFERENCE.'-'.$publisher['name'], $publisherEntity);
        }

        $manager->flush();
    }
}
