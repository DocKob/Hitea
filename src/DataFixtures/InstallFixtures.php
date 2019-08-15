<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Entity\Role;
use App\Entity\Device;
use App\Entity\Tag;
use App\Entity\Customer;
use App\Entity\Categorie;
use App\Entity\NetInterface;
use Faker\Factory;
use PhpParser\Node\Expr\New_;

class InstallFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $alltags = array('DHCP', 'DNS', 'SHARE', 'PRINT', 'ADDS', 'RDS-HOST', 'RDS-BROKER', 'RDS-GATEWAY', 'RDS-WEB', 'GPO', 'HYPER-V-HOST', 'HYPER-V-GUEST', 'WIFI-AP', 'WIFI-GATE');
        $allcats = array('WIFI', 'SERVER', 'IPBX', 'SWITCH', 'ROUTEUR', 'FIREWALL', 'PRINTER', 'DESKTOP', 'LAPTOP', 'SMART');
        $otherRoles = array('ROLE_ADMIN', 'ROLE_DEV', 'ROLE_USER');
        $InterfaceTypes = array('LAN', 'WLAN', 'WAN');

        foreach ($allcats as $cats) {
            $cat = new Categorie;
            $cat->setName($cats);
            $manager->persist($cat);
        }

        foreach ($alltags as $tags) {
            $tag = new Tag;
            $tag->setName($tags);
            $manager->persist($tag);
        }


        for ($i = 0; $i < 5; $i++) {
            $device = new Device();
            $device
                ->setName($faker->words(3, true))
                ->setDescription($faker->sentences(3, true));
            $manager->persist($device);
        }

        for ($i = 0; $i < 8; $i++) {
            $interfaces = new NetInterface;
            $interface = array_rand($InterfaceTypes);
            $interfaces
                ->setName($InterfaceTypes[$interface])
                ->setType($InterfaceTypes[$interface])
                ->setIp('192.168.1.' . $faker->numberBetween(250, 254));
            $manager->persist($interfaces);
        }

        $customer = new Customer;
        $customer->setName('The First');
        $customer->setDescription('head quarter');
        $customer->setAdress('150 Rue de la Tuque, Castelculier, Nouvelle-Aquitaine, France');
        $customer->setPhone('0553663030');
        $customer->setLat(44.1757);
        $customer->setLng(0.6836);
        $customer->setCity('Castelculier');
        $customer->setCountry('france');
        $customer->setPostalCode('47240');
        $manager->persist($customer);

        $user = new User;
        $role = new Role;
        $role->setTitle('ROLE_SUPER_ADMIN');
        $user->setEmail('demo@hitea.fr');
        $user->setPassword($this->encoder->encodePassword($user, 'demo'));
        $user->addUserRole($role);
        $manager->persist($user);
        $manager->persist($role);
        foreach ($otherRoles as $otherRole) {
            $role = new Role;
            $role->setTitle($otherRole);
            $manager->persist($role);
        }

        $manager->flush();
    }
}
