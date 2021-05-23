<?php

namespace App\Repository;

use App\Entity\SerpIntervention;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SerpIntervention|null find($id, $lockMode = null, $lockVersion = null)
 * @method SerpIntervention|null findOneBy(array $criteria, array $orderBy = null)
 * @method SerpIntervention[]    findAll()
 * @method SerpIntervention[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerpInterventionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SerpIntervention::class);
    }

    public function getAllSortedByDateDebut() {

        return $this->createQueryBuilder('i')
            ->orderBy('i.date_debut', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return SerpIntervention[] Returns an array of SerpIntervention objects
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
    public function findOneBySomeField($value): ?SerpIntervention
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
