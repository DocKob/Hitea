<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Entity\Role;

class UserFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $user = new User;
        $role = new Role;

        $role->setTitle('ROLE_SUPER_ADMIN');

        $user->setEmail('demo@hitea.fr');
        $user->setPassword($this->encoder->encodePassword($user, 'demo'));

        $user->addUserRole($role);
        $manager->persist($user);
        $manager->persist($role);

        $otherRoles = array('ROLE_ADMIN', 'ROLE_DEV', 'ROLE_USER');
        foreach ($otherRoles as $otherRole) {
            $role = new Role;
            $role->setTitle($otherRole);
            $manager->persist($role);
        }

        $manager->flush();
    }
}
