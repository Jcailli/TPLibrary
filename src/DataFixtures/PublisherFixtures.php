<?php

namespace App\DataFixtures;

use App\Entity\Publisher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PublisherFixtures extends Fixture
{
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
        ];

        foreach ($publishers as $publisher) {
            $publisherEntity = new Publisher();
            $publisherEntity->setName($publisher['name']);
            $manager->persist($publisherEntity);
        }

        $manager->flush();
    }
}
