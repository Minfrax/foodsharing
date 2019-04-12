<?php

namespace App\Repository;

use App\Entity\Cantons;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Cantons|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cantons|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cantons[]    findAll()
 * @method Cantons[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CantonsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cantons::class);
    }

    // /**
    //  * @return Cantons[] Returns an array of Cantons objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cantons
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
