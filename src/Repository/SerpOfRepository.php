<?php

namespace App\Repository;

use App\Entity\SerpOf;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SerpOf|null find($id, $lockMode = null, $lockVersion = null)
 * @method SerpOf|null findOneBy(array $criteria, array $orderBy = null)
 * @method SerpOf[]    findAll()
 * @method SerpOf[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerpOfRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SerpOf::class);
    }

    public function getAllSortedByDateCommande() {

        return $this->createQueryBuilder('o')
            ->orderBy('o.date_commande', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return SerpOf[] Returns an array of SerpOf objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SerpOf
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
