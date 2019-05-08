<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Customer;
use Faker\Factory;

class CustomerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $customer = new Customer;
        $customer->setName('The First');

        $manager->persist($customer);
        $manager->flush();
    }
}
