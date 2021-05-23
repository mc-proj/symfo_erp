<?php

namespace App\Repository;

use App\Entity\SerpIntervention;
use App\Entity\SerpTypeIntervention;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SerpTypeIntervention|null find($id, $lockMode = null, $lockVersion = null)
 * @method SerpTypeIntervention|null findOneBy(array $criteria, array $orderBy = null)
 * @method SerpTypeIntervention[]    findAll()
 * @method SerpTypeIntervention[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerpTypeInterventionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SerpTypeIntervention::class);
    }

    // /**
    //  * @return SerpTypeIntervention[] Returns an array of SerpTypeIntervention objects
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
    public function findOneBySomeField($value): ?SerpTypeIntervention
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
