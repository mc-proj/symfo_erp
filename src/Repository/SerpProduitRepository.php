<?php

namespace App\Repository;

use App\Entity\SerpProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SerpProduit|null find($id, $lockMode = null, $lockVersion = null)
 * @method SerpProduit|null findOneBy(array $criteria, array $orderBy = null)
 * @method SerpProduit[]    findAll()
 * @method SerpProduit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerpProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SerpProduit::class);
    }

    public function getAllSortedByNom() {

        return $this->createQueryBuilder('p')
            ->orderBy('p.nom', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return SerpProduit[] Returns an array of SerpProduit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SerpProduit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
