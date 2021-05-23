<?php

namespace App\Repository;

use App\Entity\SerpMatiereProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SerpMatiereProduit|null find($id, $lockMode = null, $lockVersion = null)
 * @method SerpMatiereProduit|null findOneBy(array $criteria, array $orderBy = null)
 * @method SerpMatiereProduit[]    findAll()
 * @method SerpMatiereProduit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerpMatiereProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SerpMatiereProduit::class);
    }

    // /**
    //  * @return SerpMatiereProduit[] Returns an array of SerpMatiereProduit objects
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
    public function findOneBySomeField($value): ?SerpMatiereProduit
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
