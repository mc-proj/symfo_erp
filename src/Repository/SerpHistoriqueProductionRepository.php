<?php

namespace App\Repository;

use App\Entity\SerpHistoriqueProduction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SerpHistoriqueProduction|null find($id, $lockMode = null, $lockVersion = null)
 * @method SerpHistoriqueProduction|null findOneBy(array $criteria, array $orderBy = null)
 * @method SerpHistoriqueProduction[]    findAll()
 * @method SerpHistoriqueProduction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerpHistoriqueProductionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SerpHistoriqueProduction::class);
    }

    public function getAllSortedByDateDebut() {

        return $this->createQueryBuilder('h')
            ->orderBy('h.date_debut', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return SerpHistoriqueProduction[] Returns an array of SerpHistoriqueProduction objects
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
    public function findOneBySomeField($value): ?SerpHistoriqueProduction
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
