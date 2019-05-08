<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Categorie;
use PhpParser\Node\Expr\New_;

class CategorieFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $allcats = array('NETWORK', 'SERVER', 'PABX');

        foreach ($allcats as $cats) {
            $cat = new Categorie;
            $cat->setName($cats);
            $manager->persist($cat);
        }
        $manager->flush();
    }
}
