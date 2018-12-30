<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Device;
use Faker\Factory;

class DeviceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 100; $i++) {
            $device = new Device();
            $device
                ->setName($faker->words(3, true))
                ->setDescription($faker->sentences(3, true))
                ->setIp('192.168.1.' . $faker->numberBetween(10, 254));
            $manager->persist($device);
        }

        $manager->flush();
    }
}
