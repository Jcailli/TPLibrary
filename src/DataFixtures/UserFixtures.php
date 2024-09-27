<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUserFirstName('admin');
        $user->setUsername('admin');
        $user->setPassword('$2y$13$mByMPKoQy1lXA6Nat9085Oo/iLQ0E6P6bK78C5MVY1yaay4pbxUc.'); //admin
        $user->setEmail('admin@admin.com');
        $user->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user);

        $user = new User();
        $user->setUserFirstName('librarian');
        $user->setUsername('librarian');
        $user->setPassword('$2y$13$Xlr1NXEHZWj.Qt50vEcJ1usRJ8Iz7tmFPkPgJ4I6En22w17utSdEi'); //librarian
        $user->setEmail('librarian@librarian.com');
        $user->setRoles(["ROLE_LIBRARIAN"]);
        $manager->persist($user);

        $user = new User();
        $user->setUserFirstName('user');
        $user->setUsername('user');
        $user->setPassword('$2y$13$CsW8X1FU0/L2dg/i90FnOumR9NV9uy806G3Ozv9IVPJUhZqr6sl62'); //user
        $user->setEmail('user@user.com');
        $user->setRoles(["ROLE_USER"]);
        $manager->persist($user);

        $manager->flush();
    }
}
