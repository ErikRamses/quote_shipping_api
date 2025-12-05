<?php

namespace App\DataFixtures;

use App\Entity\Provider;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('user@example.com');
        $user->setPassword('password');
        $manager->persist($user);
        // Proveedor Exitoso
        $provider1 = new Provider();
        $provider1->setName('Fast Track Logistics');
        $provider1->setSlug('fast_track'); // Debe coincidir con el código PHP
        $provider1->setApiUrl('https://webhook.site/4dc99560-1e43-4fef-80bb-efcb4abe1789'); // Pon tu URL real
        $provider1->setIsActive(true);
        $manager->persist($provider1);

        // Proveedor Fallido
        $provider2 = new Provider();
        $provider2->setName('Hiker Cargo');
        $provider2->setSlug('hiker_cargo');
        $provider2->setApiUrl('https://webhook.site/8ce84c4a-27fa-4f63-a5f6-d0dd964b86be'); // Pon tu URL real o rota
        $provider2->setIsActive(true);
        $manager->persist($provider2);

        $manager->flush();
    }
}