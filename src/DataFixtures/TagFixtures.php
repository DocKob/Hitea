<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Tag;

class TagFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $alltags = array('DHCP', 'DNS', 'SHARE');

        foreach ($alltags as $tags) {
            $tag = new Tag;
            $tag->setName($tags);
            $manager->persist($tag);
        }
        $manager->flush();
    }
}
