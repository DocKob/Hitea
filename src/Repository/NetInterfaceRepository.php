<?php

namespace App\Repository;

use App\Entity\NetInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method NetInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method NetInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method NetInterface[]    findAll()
 * @method NetInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NetInterfaceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NetInterface::class);
    }

    // /**
    //  * @return NetInterface[] Returns an array of NetInterface objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NetInterface
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
